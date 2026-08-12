# GoGoGo

Community event platform — rewrite on Laravel 13 with Breeze (Blade + Alpine).

## Requirements

- PHP 8.5+
- Composer 2.x
- Node 22+ / npm 10+
- SQLite (local dev) or MySQL 8 (production)

## Local setup

```bash
# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database (SQLite for local dev — already configured in .env.example)
touch database/database.sqlite
php artisan migrate

# Create the first admin account (interactive)
php artisan app:make-admin

# Build assets
npm run build   # production build
npm run dev     # dev server with HMR

# Serve
php artisan serve
```

## Create admin account

Interactive:
```bash
php artisan app:make-admin
```

Non-interactive (CI / scripts):
```bash
ADMIN_PASSWORD='your-secure-password' php artisan app:make-admin \
    --name="Admin" --email="admin@example.com" --password-stdin
```

Or via stdin pipe:
```bash
echo 'your-secure-password' | php artisan app:make-admin \
    --name="Admin" --email="admin@example.com" --password-stdin
```

No default accounts are seeded. The first admin must be created manually.

## User ranks

| Rank      | Description                     |
|-----------|---------------------------------|
| `admin`   | Full access                     |
| `support` | Staff-level access              |
| `member`  | Default rank for regular users  |

Middleware: `rank:admin`, `rank:admin,support`, etc.

## Production notes

- Database: MySQL 8 — set `DB_CONNECTION=mysql` and configure `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in `.env`
- The `proto/` directory contains static HTML design references and is not served by the application

## Tests

```bash
php artisan test
```
