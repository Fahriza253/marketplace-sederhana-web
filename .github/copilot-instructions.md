# Copilot Instructions for Marketplace Sederhana

## Project Overview
- **Framework:** Laravel (PHP) with Livewire for reactive components, Tailwind CSS for styling, and Vite for asset bundling.
- **Structure:**
  - `app/Http/Controllers/` — Standard Laravel controllers
  - `app/Livewire/` — Livewire components (organized by feature)
  - `app/Models/` — Eloquent models (e.g., Product, User, Role)
  - `routes/web.php` — Main web routes (uses both controllers and Livewire classes)
  - `resources/views/` — Blade templates, including Livewire and component layouts
  - `database/seeders/` — Seeders for roles, users, and products
  - `config/` — Laravel configuration (database, services, session, etc.)

## Key Patterns & Conventions
- **Livewire:** Use for most UI logic; components are grouped by feature (e.g., `Product/Index.php`).
- **Role-based Access:** Custom middleware `RoleGuard` (see `app/Http/Middleware/RoleGuard.php`) is aliased as `role` in `bootstrap/app.php`.
- **Authentication:** Manual routes for login/register in `routes/web.php` (not default Laravel Breeze/Jetstream).
- **Seeder Usage:** Roles and users are seeded with `php artisan db:seed` (see `database/seeders/`).
- **Blade Layouts:** Use `resources/views/components/layouts/app/default.blade.php` and `auth/default.blade.php` for main layouts. Navigation is componentized.
- **Asset Pipeline:** Vite is configured in `vite.config.js` with Tailwind and Laravel plugins. Use `@vite` in Blade for asset loading.

## Developer Workflows
- **Install dependencies:**
  - PHP: `composer install`
  - JS/CSS: `npm install`
- **Build assets:**
  - Dev: `npm run dev`
  - Prod: `npm run build`
- **Run server:** `php artisan serve`
- **Database:**
  - Migrate: `php artisan migrate`
  - Seed: `php artisan db:seed`
- **Testing:**
  - Feature/unit tests: `php artisan test` or `vendor/bin/phpunit`
- **Custom Commands:** See `routes/console.php` for any custom Artisan commands.

## Integration & External Services
- **Third-party services:** Configured in `config/services.php` (e.g., Postmark, SES, Slack). Use `env()` for credentials.
- **Session:** Default is `database` driver (see `config/session.php`).

## Notable Customizations
- **Manual Auth:** Login/register flows are custom, not using Laravel starter kits.
- **Role Middleware:** Use `->middleware('role:admin')` for route protection.
- **Product Details:** Uses single-action controller (`ProductDetailController`) for product pages.

## Examples
- **Protecting a route:**
  ```php
  Route::middleware('role:admin')->group(function () {
      // admin-only routes
  });
  ```
- **Livewire route:**
  ```php
  Route::get('/products', Product\Index::class);
  ```

## References
- Main entry: `public/index.php`, `bootstrap/app.php`
- See `README.md` and `docs/TODO.md` for additional context and tasks.

---
For new patterns, follow existing directory and naming conventions. When in doubt, check for similar implementations in `app/Livewire/` and `routes/web.php`.
