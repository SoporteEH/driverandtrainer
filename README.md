# Driver & Trainer

Internal management application for drivers. Handles transport job assignments, expense tracking, and role-based access control.

## Tech Stack

- **PHP** 8.2+ / **Laravel** 12
- **Filament** 3 — admin panel
- **Livewire** 3 — reactive UI components
- **Spatie Laravel Permission** — roles and permissions
- **Tailwind CSS** 4 + **Flowbite** — frontend styling
- **Vite** — asset bundling
- **SQLite** — default database

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+ / npm
- A supported database (SQLite by default)

## Installation
composer install

cp .env.example .env
php artisan key:generate

php artisan migrate --seed

npm install
npm run build
```

Configure your database connection in `.env` before running migrations.

## Development

```bash
composer dev
```

Starts the Laravel dev server, queue worker, log watcher (Pail), and Vite concurrently.

Alternatively, run each service individually:

```bash
php artisan serve
npm run dev
```

## Features

- Transport job management (create, edit, status tracking)
- Expense attachment per job (fuel, food, promoter receipts)
- Role-based access: admin panel via Filament, driver-facing views
- File upload and storage for expense documents

## Environment

Copy `.env.example` to `.env` and adjust:

| Variable | Description |
|---|---|
| `APP_URL` | Application base URL |
| `DB_CONNECTION` | Database driver (`sqlite`, `mysql`, etc.) |
| `MAIL_*` | Mail configuration |

## License

Private — all rights reserved.
