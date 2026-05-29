# AGENTS.md — Meeting Room Booking System

## Architecture

Four subsystems share one MySQL database:

| Subsystem | Entrypoint | Auth | Tables | Tech |
|-----------|-----------|------|--------|------|
| **Laravel Web** (main) | `routes/web.php` | Session (username/password) | `meetings` | Laravel 13, Blade, Tailwind v4 |
| **Laravel API** (dead code) | `routes/api.php` (not registered) | Sanctum | `bookings` | Unused controllers |
| **Express API** (auxiliary) | `api/server.js`, port 3000 | JWT Bearer (24h) | `bookings` | Express, mysql2, JWT |
| **Frontend** (static) | `frontend/index.html` | Consumes Express API | — | Vanilla JS, FullCalendar CDN |

**Critical**: `routes/api.php` and `app/Http/Controllers/Api/` are **not wired** — `bootstrap/app.php` only registers `web.php`, `auth.php`, and `console.php`. Do not add routes to `routes/api.php` unless you also register it in `bootstrap/app.php`.

**Role case mismatch**: Express API checks for `role === 'ADMIN'` (uppercase). Laravel Web uses lowercase `'admin'`. The `users` table stores lowercase. Express `requireAdmin` will never match — known limitation.

**Login field mismatch**: Express API login uses `email` field; Laravel Web login uses `username` field — both reference the same `users` table.

## Roles & Middleware

Roles: `user`, `koordinator`, `head_of_store`, `gm`, `hr`, `admin`.

`FULL_ACCESS_ROLES` = `['admin', 'head_of_store', 'gm', 'hr']` — defined in `app/Models/User.php`.

Middleware aliases (from `bootstrap/app.php`):
- `admin` → `AdminMiddleware` — any full access role
- `admin_hr` → `AdminHrMiddleware` — `admin` + `hr` only
- `manage_accounts` → `CanManageAccountsMiddleware` — `admin` for `/admins/*`, `admin`+`hr` for `/users/*`
- `leader` → `LeaderMiddleware` — `koordinator`, `head_of_store`, `gm`, `hr` (not `admin`)
- `role:x,y,z` → `RoleMiddleware` — generic check

## Developer Commands

```bash
# Full dev env (server + queue + logs + Vite concurrently)
composer dev

# Tests (config:clear first, then php artisan test; uses SQLite in-memory)
composer test

# Formatter
./vendor/bin/pint

# Full setup (composer install + .env + key:generate + migrate + npm build)
composer setup

# Laravel server only
php artisan serve

# Queue worker (required for notifications, weekly processing)
php artisan queue:listen --tries=1 --timeout=0

# Live log viewer
php artisan pail --timeout=0

# Vite dev / production build
npm run dev
npm run build

# Generate VAPID keys for push notifications
php artisan vapid:generate

# Express API (separate terminal)
cd api && npm run dev    # nodemon
cd api && npm start      # production

# List all registered Laravel routes
php artisan route:list
```

## Testing

- `tests/Unit/` and `tests/Feature/` — PHPUnit with SQLite `:memory:`
- **Always** `composer test` (not `php artisan test` directly) — it runs `config:clear` first
- `phpunit.xml` overrides `SESSION_DRIVER=array`, `QUEUE_CONNECTION=sync`, `CACHE_STORE=array`

## Database

- **Dev**: MySQL (`meeting_room_db`) in `.env`; `.env.example` defaults to SQLite — update before `composer setup`
- **Test**: SQLite in-memory
- Session, queue, cache all use `database` driver by default
- Default accounts (password `password`): `admin`, `headstore`, `gm`, `hr`, `koordinator1`, `user1` — see `database/seeders/DatabaseSeeder.php`
- Two table families: `meetings` (Laravel Web) and `bookings` (Express API) — **not synced**; `rooms` and `users` are shared
- Express API `api/.env` is **separate** from root `.env` — configure independently

## Quirks

- `weekly:process` artisan command runs **every minute** via `routes/console.php` — generates weekly meeting sessions + push notifications
- `MeetingQueueService::assignQueue()` auto-trims overlapping meeting end times and assigns queue positions
- `gaming.css` auto-synced from `resources/css/gaming.css` → `public/css/gaming.css` on boot via `AppServiceProvider`
- Frontend (`frontend/`) is plain HTML/JS — no build step; uses CDN for Tailwind CSS v2 and FullCalendar v6
- Timezone: `Asia/Jakarta`, locale: `id` — set in `config/app.php` (overridable via `.env`)
