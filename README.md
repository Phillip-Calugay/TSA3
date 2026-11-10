# Tasks for Today — TSA3 (Laravel)

Laravel conversion of Phillip Calugay's TSA1 CodeIgniter application. The four pages preserve the original layout, navigation, task records, and demo profile. Data retrieval uses Eloquent; the schema and demo data are supplied by migrations and a seeder.

## Requirements

- PHP 8.2 or newer, Composer, and the PHP extensions required by Laravel (including PDO SQLite for the default database).
- MySQL is also supported through Laravel's database configuration.
- Node.js is not required: the pages use a plain stylesheet in `public/css/tasks.css`.

## Set up and run

From the project directory:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database/database.sqlite -Force
php artisan migrate --seed
php artisan serve
```

For an existing installation, keep your `.env` and SQLite database and run `php artisan migrate --seed`. Do not recreate or replace a database containing your own records.

Open http://127.0.0.1:8000. The database defaults to SQLite. `APP_TIMEZONE=Asia/Manila` determines what counts as today, including when the server uses another timezone.

## Pages

| URL | Behavior |
| --- | --- |
| `/` | Today's tasks only, filtered by `task_date` using an Eloquent scope |
| `/tasks` | Every task, ordered by date and then ID |
| `/profile` | The single seeded user's username, full name, email, and membership date |
| `/about` | Application description and developer Phillip Calugay |

The layout uses Blade, escaped output, and named routes. Both task pages share a table partial and include an empty state.

## Database and sample data

- `tasks`: ID, title (150), status (20, default `pending`), indexed task_date, created_at, updated_at.
- `users`: ID, unique username (50), full_name (100), email (100), created_at, updated_at.
- The standard starter migrations remain; a follow-up migration converts Laravel's starter user fields to TSA1's profile fields. Cache, jobs, and session tables are Laravel infrastructure.
- On a clean database, `DatabaseSeeder` creates exactly one user (`demo_student`, Demo Student, demo.student@example.com) and ten tasks.
- The original eight TSA1 task titles, statuses, and dates (September 30 through October 2, 2026) are preserved. Two additional tasks use the current local date when seeded, satisfying TSA3's requirement to include today.
- Repeating `php artisan db:seed` updates the same demo records without creating duplicates. It moves the two additional tasks to the current day. If no tasks are dated today on a later visit, the welcome page correctly displays its empty message.
- The seeder does not delete independently added records; the exactly-one-user requirement describes a clean seeded installation.

Migration and seeder files are included under `database/`, satisfying the assignment's database submission requirement without a separate SQL export.

## Verification

```powershell
php artisan test
php artisan route:list --except-vendor
```

Tests use an isolated in-memory SQLite database. They cover local date filtering at the UTC day boundary, ordering, profile and About content, empty states, escaped titles, default status, unique usernames, and repeated seeding.

## Hosting and submission

1. Create a GitHub repository and push the project files, including `composer.lock`, migrations, and seeder. Exclude `.env`, `vendor/`, and local database files as configured by `.gitignore`.
2. Use a PHP host that supports this project's Laravel/PHP requirements. Set the web document root to this project's `public/` directory; on XAMPP, configure an Apache virtual host to `C:/xampp/htdocs/TSA3/public`.
3. Run `composer install --no-dev --optimize-autoloader`. Configure the server `.env` with `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` set to the hosted HTTPS URL, `APP_TIMEZONE=Asia/Manila`, and the database connection.
4. Generate the application key once with `php artisan key:generate`. Make `storage/` and `bootstrap/cache/` writable by PHP. For SQLite, create a writable database file and configure its absolute path; for MySQL, create the database and set `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.
5. Run `php artisan migrate --seed --force`, then `php artisan config:cache` and `php artisan view:cache`.
6. Check all four public pages and submit both the GitHub repository URL and working hosted URL.

Repository creation and public deployment require the destination account and host configuration; this local conversion does not create those links automatically.
