# Meeting Room Booking System

A comprehensive meeting room booking system built with Laravel (backend) and Express.js (API) with a modern frontend interface.

## Features

### 🔐 Authentication

- User registration and login
- JWT-based authentication for API
- Role-based access control (USER/ADMIN)

### 🏢 Room Management

- View available meeting rooms
- Admin can add, edit, and delete rooms
- Room details include capacity, facilities, and location

### 📅 Booking System

- Book meeting rooms with conflict validation
- View bookings in calendar format
- Admin can manage all bookings
- Users can view and cancel their own bookings

### 📱 Responsive Design

- Mobile-friendly interface
- Modern UI with Tailwind CSS
- Interactive calendar with FullCalendar.js

## Tech Stack

### Backend (Laravel)

- Laravel Framework 13
- PHP 8.3
- MySQL Database
- Blade Templates
- Session-based authentication

### API Backend (Express.js)

- Node.js with Express
- MySQL2 for database connection
- JWT authentication
- Express-validator for input validation
- CORS enabled

### Frontend

- Vanilla JavaScript
- Tailwind CSS for styling
- FullCalendar.js for calendar view
- Responsive design

## Installation

### Prerequisites

- PHP 8.3+
- Node.js 16+
- MySQL 8.0+
- Composer
- Laravel requirements

### Laravel Backend Setup

1. Navigate to the project root:

    ```bash
    cd c:\laragon\www\meeting-room
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Copy environment file:

    ```bash
    cp .env.example .env
    ```

4. Configure database in `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=meeting_room_db
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5. Generate application key:

    ```bash
    php artisan key:generate
    ```

6. Run migrations and seeders:

    ```bash
    php artisan migrate --seed
    ```

7. Start Laravel development server:
    ```bash
    php artisan serve
    ```

### Express API Setup

1. Navigate to API directory:

    ```bash
    cd api
    ```

2. Install Node.js dependencies:

    ```bash
    npm install
    ```

3. Configure environment variables in `.env`:

    ```env
    DB_HOST=localhost
    DB_USER=your_username
    DB_PASSWORD=your_password
    DB_NAME=meeting_room_db
    JWT_SECRET=your_jwt_secret_key
    PORT=3000
    ```

4. Start the API server:
    ```bash
    npm start
    ```

### Frontend Setup

1. Open `frontend/index.html` in a web browser or serve via a web server
2. The frontend will connect to the Express API at `http://localhost:3000`

## API Endpoints

### Authentication

- `POST /auth/login` - User login

### Rooms

- `GET /rooms` - Get all active rooms
- `POST /rooms` - Create new room (admin only)
- `PUT /rooms/:id` - Update room (admin only)
- `DELETE /rooms/:id` - Delete room (admin only)

### Bookings

- `GET /bookings?date=YYYY-MM-DD` - Get bookings (filtered by date if provided)
- `POST /bookings` - Create new booking
- `DELETE /bookings/:id` - Delete booking (owner or admin only)

## Database Schema

### Users Table

- `id` - Primary key
- `name` - User's full name
- `email` - Email address (unique)
- `password` - Hashed password
- `role` - User role (USER/ADMIN)

### Rooms Table

- `id` - Primary key
- `name` - Room name
- `capacity` - Maximum capacity
- `facilities` - JSON array of facilities
- `location` - Room location
- `description` - Room description
- `is_active` - Active status

### Bookings Table

- `id` - Primary key
- `user_id` - Foreign key to users
- `room_id` - Foreign key to rooms
- `title` - Booking title
- `description` - Booking description
- `participants` - Participants list
- `start_time` - Booking start time
- `end_time` - Booking end time
- `status` - Booking status (approved/cancelled)

## Usage

1. **Login**: Use the login form to authenticate
2. **Dashboard**: View available rooms, your bookings, and today's bookings
3. **Calendar**: See all bookings in calendar format
4. **Book Room**: Click "Book Room" to create a new booking
5. **Admin Panel**: Admin users can manage rooms and view all bookings

## Development

### Running Tests

```bash
# Laravel tests
php artisan test

# API tests (if implemented)
npm test
```

### Code Quality

```bash
# Laravel code formatting
./vendor/bin/pint

# Laravel static analysis (if installed)
./vendor/bin/phpstan analyse
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests and ensure code quality
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
