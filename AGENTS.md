# AGENTS.md — Meeting Room Booking System

## Architecture

Four subsystems in one repo, sharing the same MySQL database:

| Subsystem | Entrypoint | Auth | Tables | Tech |
|-----------|-----------|------|--------|------|
| **Laravel Web** (main) | `routes/web.php` | Session (username/password) | `meetings` | Laravel 13, Blade, Tailwind v4 |
| **Laravel API** (dead code) | `routes/api.php` (not registered) | Sanctum | `bookings` | Laravel controllers, unused |
| **Express API** (auxiliary) | `api/server.js` | JWT Bearer, 24h expiry | `bookings` | Express, mysql2, JWT |
| **Frontend** (static) | `frontend/index.html` | Consumes Express API at `:3000` | — | Vanilla JS, FullCalendar |

**Critical**: `routes/api.php` and `app/Http/Controllers/Api/` are **not wired** — `bootstrap/app.php:12` only registers `web.php`, `auth.php`, and `console.php`. Do not add routes to `routes/api.php` unless you register it first.

## Roles & Access (Laravel Web)

Roles: `user`, `koordinator`, `head_of_store`, `gm`, `hr`, `admin`.

**FULL_ACCESS_ROLES** = `['admin', 'head_of_store', 'gm', 'hr']` — have full admin access.
**Middleware** (aliased in `bootstrap/app.php:18`):
- `admin` → `AdminMiddleware` — any full access role
- `admin_hr` → `AdminHrMiddleware` — `admin` + `hr` only
- `manage_accounts` → `CanManageAccountsMiddleware` — `admin` for `/admins/*`, `admin`+`hr` for `/users/*`
- `leader` → `LeaderMiddleware` — `koordinator`, `head_of_store`, `gm`, `hr` (not `admin`)
- `role:x,y,z` → `RoleMiddleware` — generic role check

## Routes (Laravel Web, see `routes/web.php`)

- `/` — redirects to role-specific dashboard (or login)
- `/admin/*` under `admin` middleware: teams, assets
- `/admin/*` under `admin_hr` middleware: rooms, meetings, weekly-meetings
- `/admin/users` under `manage_accounts`: `admin`+`hr`; `/admin/admins`: `admin` only
- `/koordinator/*` under `leader` middleware: meetings, MoM
- `/user/*` under `role:user,koordinator,admin,head_of_store,gm,hr`: dashboard
- `/calendar`, `/invitations/*`, `/profile/*`, `/push/*`, `/weekly-undangan/*` — auth required, any role

## Developer Commands

```bash
# Full dev environment (servers + queue + logs + Vite concurrently)
composer dev

# Tests (config:clear first, then php artisan test; uses SQLite in-memory)
composer test

# Formatter
./vendor/bin/pint

# Setup from scratch (composer install + .env + key:generate + migrate + npm build)
composer setup

# Laravel server only
php artisan serve

# Queue worker (required for notifications, weekly processing)
php artisan queue:listen --tries=1 --timeout=0

# Live log viewer
php artisan pail --timeout=0

# Vite dev
npm run dev

# List all registered routes
php artisan route:list
```

## Express API (port 3000)

```bash
cd api && npm run dev    # nodemon (dev)
cd api && npm start      # node (production)
```

- Separate `api/.env` with its own `JWT_SECRET`
- Routes: `POST /auth/login`, `GET/POST /rooms`, `PUT/DELETE /rooms/:id`, `GET/POST /bookings`, `DELETE /bookings/:id`
- Login uses `email` field; Laravel web uses `username`

## Testing

- Tests in `tests/Unit/` and `tests/Feature/`
- PHPUnit with SQLite `:memory:` (configured in `phpunit.xml`)
- **Always use `composer test`** (not `php artisan test` directly) — it runs `config:clear` first
- `phpunit.xml` overrides `SESSION_DRIVER=array`, `QUEUE_CONNECTION=sync`, `CACHE_STORE=array` for tests

## Database

- **Dev**: MySQL (`meeting_room_db`) — configured in `.env`; `.env.example` defaults to SQLite, update before setup
- **Test**: SQLite in-memory
- Session, queue, and cache all use database driver
- Default accounts (password `password`): `admin`, `headstore`, `gm`, `hr`, `koordinator1`, `user1` — see `database/seeders/DatabaseSeeder.php`
- Two table families: `meetings` (Laravel Web) and `bookings` (Express API) — **not synced**
- `rooms` and `users` tables are shared by all subsystems

## Important Quirks

- `weekly:process` artisan command runs **every minute** via `routes/console.php` — generates weekly meeting sessions and sends push notifications
- VAPID keys for push notifications in `.env` (public + private); requires queue worker running
- `MeetingQueueService::assignQueue()` auto-trims meeting end times on overlap and assigns queue positions
- `gaming.css` auto-synced from `resources/css/gaming.css` → `public/css/gaming.css` on boot via `AppServiceProvider`
- `.editorconfig`: 4-space indent, LF line endings
- `api/.env` is separate from root `.env` — both must be configured independently
- No `opencode.json`, `.cursorrules`, or other instruction files exist
