const express = require('express');
const { body, validationResult, query } = require('express-validator');
const { authenticateToken, requireAdmin } = require('../middleware/auth');

const router = express.Router();

// Helper function to check for booking conflicts
async function checkBookingConflict(db, roomId, startTime, endTime, excludeBookingId = null) {
  let query = `
    SELECT id FROM bookings
    WHERE room_id = ?
    AND status != 'cancelled'
    AND (
      (start_time < ? AND end_time > ?) OR
      (start_time < ? AND end_time > ?) OR
      (start_time >= ? AND end_time <= ?)
    )
  `;
  let params = [roomId, endTime, startTime, startTime, endTime, startTime, endTime];

  if (excludeBookingId) {
    query += ' AND id != ?';
    params.push(excludeBookingId);
  }

  const [conflicts] = await db.execute(query, params);
  return conflicts.length > 0;
}

// GET /bookings?date=YYYY-MM-DD
router.get('/', authenticateToken, [
  query('date').optional().isISO8601()
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    let query = `
      SELECT b.id, b.title, b.description, b.participants, b.start_time, b.end_time, b.status,
             r.name as room_name, r.location as room_location,
             u.name as user_name
      FROM bookings b
      JOIN rooms r ON b.room_id = r.id
      JOIN users u ON b.user_id = u.id
      WHERE b.status != 'cancelled'
    `;
    let params = [];

    if (req.query.date) {
      query += ' AND DATE(b.start_time) = ?';
      params.push(req.query.date);
    }

    // If not admin, only show user's own bookings
    if (req.user.role !== 'ADMIN') {
      query += ' AND b.user_id = ?';
      params.push(req.user.id);
    }

    query += ' ORDER BY b.start_time';

    const [bookings] = await req.db.execute(query, params);

    res.json(bookings);

  } catch (error) {
    console.error('Get bookings error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// POST /bookings
router.post('/', authenticateToken, [
  body('room_id').isInt(),
  body('title').notEmpty().trim(),
  body('description').optional().trim(),
  body('participants').optional().trim(),
  body('start_time').isISO8601(),
  body('end_time').isISO8601().custom((endTime, { req }) => {
    if (new Date(endTime) <= new Date(req.body.start_time)) {
      throw new Error('End time must be after start time');
    }
    return true;
  })
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const { room_id, title, description, participants, start_time, end_time } = req.body;

    // Check if room exists and is active
    const [rooms] = await req.db.execute(
      'SELECT id FROM rooms WHERE id = ? AND is_active = 1',
      [room_id]
    );

    if (rooms.length === 0) {
      return res.status(400).json({ error: 'Invalid or inactive room' });
    }

    // Check for booking conflicts
    const hasConflict = await checkBookingConflict(req.db, room_id, start_time, end_time);
    if (hasConflict) {
      return res.status(409).json({ error: 'Room is not available at the selected time' });
    }

    // Create booking
    const [result] = await req.db.execute(
      'INSERT INTO bookings (user_id, room_id, title, description, participants, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
      [req.user.id, room_id, title, description || '', participants || '', start_time, end_time, 'approved']
    );

    res.status(201).json({
      id: result.insertId,
      user_id: req.user.id,
      room_id,
      title,
      description,
      participants,
      start_time,
      end_time,
      status: 'approved'
    });

  } catch (error) {
    console.error('Create booking error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// DELETE /bookings/:id
router.delete('/:id', authenticateToken, async (req, res) => {
  try {
    const { id } = req.params;

    // Check if booking exists and user owns it (or is admin)
    let query = 'SELECT id, user_id FROM bookings WHERE id = ?';
    let params = [id];

    if (req.user.role !== 'ADMIN') {
      query += ' AND user_id = ?';
      params.push(req.user.id);
    }

    const [bookings] = await req.db.execute(query, params);

    if (bookings.length === 0) {
      return res.status(404).json({ error: 'Booking not found' });
    }

    // Delete booking
    await req.db.execute('DELETE FROM bookings WHERE id = ?', [id]);

    res.json({ message: 'Booking deleted successfully' });

  } catch (error) {
    console.error('Delete booking error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

module.exports = router;