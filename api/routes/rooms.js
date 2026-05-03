const express = require('express');
const { body, validationResult } = require('express-validator');
const { authenticateToken, requireAdmin } = require('../middleware/auth');

const router = express.Router();

// GET /rooms
router.get('/', authenticateToken, async (req, res) => {
  try {
    const [rooms] = await req.db.execute(
      'SELECT id, name, capacity, facilities, location, description, is_active FROM rooms WHERE is_active = 1 ORDER BY name'
    );

    // Parse facilities JSON
    const processedRooms = rooms.map(room => ({
      ...room,
      facilities: room.facilities ? JSON.parse(room.facilities) : []
    }));

    res.json(processedRooms);
  } catch (error) {
    console.error('Get rooms error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// POST /rooms (admin only)
router.post('/', authenticateToken, requireAdmin, [
  body('name').notEmpty().trim(),
  body('capacity').isInt({ min: 1 }),
  body('facilities').optional().isArray(),
  body('location').notEmpty().trim(),
  body('description').optional().trim()
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const { name, capacity, facilities, location, description } = req.body;

    const [result] = await req.db.execute(
      'INSERT INTO rooms (name, capacity, facilities, location, description, is_active) VALUES (?, ?, ?, ?, ?, 1)',
      [name, capacity, JSON.stringify(facilities || []), location, description || '']
    );

    res.status(201).json({
      id: result.insertId,
      name,
      capacity,
      facilities: facilities || [],
      location,
      description,
      is_active: 1
    });

  } catch (error) {
    console.error('Create room error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// PUT /rooms/:id (admin only)
router.put('/:id', authenticateToken, requireAdmin, [
  body('name').notEmpty().trim(),
  body('capacity').isInt({ min: 1 }),
  body('facilities').optional().isArray(),
  body('location').notEmpty().trim(),
  body('description').optional().trim(),
  body('is_active').optional().isBoolean()
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const { id } = req.params;
    const { name, capacity, facilities, location, description, is_active } = req.body;

    const [result] = await req.db.execute(
      'UPDATE rooms SET name = ?, capacity = ?, facilities = ?, location = ?, description = ?, is_active = ? WHERE id = ?',
      [name, capacity, JSON.stringify(facilities || []), location, description || '', is_active ? 1 : 0, id]
    );

    if (result.affectedRows === 0) {
      return res.status(404).json({ error: 'Room not found' });
    }

    res.json({
      id: parseInt(id),
      name,
      capacity,
      facilities: facilities || [],
      location,
      description,
      is_active: is_active ? 1 : 0
    });

  } catch (error) {
    console.error('Update room error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

// DELETE /rooms/:id (admin only)
router.delete('/:id', authenticateToken, requireAdmin, async (req, res) => {
  try {
    const { id } = req.params;

    const [result] = await req.db.execute(
      'DELETE FROM rooms WHERE id = ?',
      [id]
    );

    if (result.affectedRows === 0) {
      return res.status(404).json({ error: 'Room not found' });
    }

    res.json({ message: 'Room deleted successfully' });

  } catch (error) {
    console.error('Delete room error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
});

module.exports = router;