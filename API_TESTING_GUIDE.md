# Meeting Room Booking API - Testing Guide

## 🚀 Quick Start

### 1. Start Server

```bash
cd c:\laragon\www\meeting-room
php artisan serve
```

Server akan berjalan di: `http://127.0.0.1:8000`

### 2. Import POSTMAN Collection

- Import file `postman_collection.json` ke POSTMAN
- Set variable `base_url` = `http://127.0.0.1:8000`

### 3. Sample Accounts

```
Admin: admin@example.com / password
User:  test@example.com / password
```

## 📋 API Testing Steps

### Step 1: Login

1. Buka request **"Login"** di POSTMAN
2. Ganti email/password jika perlu
3. Klik **Send**
4. **Copy token** dari response

### Step 2: Set Authorization

1. Di POSTMAN, klik tab **Authorization**
2. Pilih **Bearer Token**
3. Paste token yang dicopy dari login

### Step 3: Test Endpoints

1. **GET /api/rooms** - Lihat semua ruangan
2. **POST /api/bookings** - Buat booking baru
3. **GET /api/bookings** - Lihat semua booking
4. **DELETE /api/bookings/{id}** - Hapus booking

## 🔧 Manual Testing dengan cURL

### Login

```bash
curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'
```

### Get Rooms (dengan token)

```bash
curl -X GET http://127.0.0.1:8000/api/rooms \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### Create Booking

```bash
curl -X POST http://127.0.0.1:8000/api/bookings \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "room_id": 1,
    "title": "Test Meeting",
    "start_time": "2026-05-02T10:00:00",
    "end_time": "2026-05-02T11:00:00"
  }'
```

## 📊 Sample Data

### Rooms Available:

- ID 1: Conference Room A (capacity: 10)
- ID 2: Meeting Room B (capacity: 6)
- ID 3: Board Room (capacity: 20)
- ID 4: Training Room (capacity: 15)

### Test Scenarios:

#### ✅ Valid Booking

```json
{
    "room_id": 1,
    "title": "Team Meeting",
    "start_time": "2026-05-02T14:00:00",
    "end_time": "2026-05-02T15:00:00"
}
```

#### ❌ Conflict Booking (akan fail)

```json
{
    "room_id": 1,
    "title": "Another Meeting",
    "start_time": "2026-05-02T14:30:00",
    "end_time": "2026-05-02T15:30:00"
}
```

#### ❌ Invalid Time (end before start)

```json
{
    "room_id": 1,
    "title": "Wrong Time",
    "start_time": "2026-05-02T15:00:00",
    "end_time": "2026-05-02T14:00:00"
}
```

## 🔍 Response Examples

### Success Response

```json
{
    "message": "Booking created successfully",
    "booking": {
        "id": 1,
        "user_id": 1,
        "room_id": 1,
        "title": "Team Meeting",
        "start_time": "2026-05-02T14:00:00.000000Z",
        "end_time": "2026-05-02T15:00:00.000000Z",
        "status": "approved"
    }
}
```

### Error Response

```json
{
    "error": "Room is not available at the selected time"
}
```

## 🐛 Troubleshooting

### Token Expired

- Login lagi untuk dapat token baru

### 403 Forbidden

- Pastikan menggunakan admin account untuk admin-only endpoints

### 409 Conflict

- Ruangan sudah dibooking pada waktu tersebut
- Coba waktu yang berbeda

### 401 Unauthorized

- Token tidak valid atau missing
- Pastikan header: `Authorization: Bearer YOUR_TOKEN`

## 📱 Alternative Testing Tools

Selain POSTMAN, bisa gunakan:

- **Thunder Client** (VS Code extension)
- **Insomnia**
- **Browser DevTools** dengan fetch API
- **curl** commands (seperti di atas)

## 🎯 Next Steps

Setelah API testing berhasil:

1. **Frontend Integration**: Connect frontend ke API
2. **Mobile App**: Buat mobile app yang consume API ini
3. **Additional Features**: Email notifications, calendar sync, etc.

---

**Happy Testing! 🎉**
