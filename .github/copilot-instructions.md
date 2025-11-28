<!-- .github/copilot-instructions.md: guidance for AI coding agents working on Ping CRM -->

# Repo overview

This is a Laravel 11 application using Inertia.js + Vue 3 on the frontend and Vite for assets. The backend is PHP (PSR-4 autoloading) and the frontend lives under `resources/js` (Inertia pages and Vue components).

- Backend entry points: `routes/web.php` (HTTP routes) and controllers in `app/Http/Controllers`.
- Frontend pages: `resources/js/Pages/*`. Example: `LotteryController::index` renders `Lottery/Index` (i.e. `resources/js/Pages/Lottery/Index.vue`).
- Models live in `app/Models/` and a few legacy-style model files exist under `app/` (e.g. `Account.php`, `Contact.php`). Use the PSR-4 namespace `App\\` when referencing classes.

# Quick setup & common commands

- Install PHP deps: `composer install`
- Install JS deps: `npm ci`
- Dev assets (hot reload): `npm run dev` (runs `vite`)
- Build assets: `npm run build` (includes SSR build)
- Create .env: `cp .env.example .env` and `php artisan key:generate`
- DB (local quick start): `touch database/database.sqlite`, then `php artisan migrate` and `php artisan db:seed`
- Run: `php artisan serve`
- Tests: `phpunit`
- JS code style: `npm run fix:eslint` and `npm run fix:prettier`

# Architecture notes AI should know

- Inertia patterns: controllers return `Inertia::render('Page/Name', $props)`. Look for the corresponding Vue page at `resources/js/Pages/Page/Name.vue` or `resources/js/Pages/Page/Name/index.vue`.
- Route middleware is used to gate pages: routes in `routes/web.php` use `->middleware('auth')` or `->middleware('guest')` — preserve these conventions when adding routes.
- Database migrations and seeders live under `database/migrations` and `database/seeders`. The project often uses SQLite for local testing (README).
- Frontend build: Vite with `laravel-vite-plugin`. SSR is enabled via the second `vite build` call in `package.json`'s `build` script.

# Project-specific conventions & examples

- Route naming: most routes are given a name via `->name('contacts')` — follow this pattern when adding routes and use named routes in Inertia links.
- Controller -> Page mapping example: `app/Http/Controllers/LotteryController.php` uses `Inertia::render('Lottery/Index')`. To change client output, update the corresponding Vue page in `resources/js/Pages/Lottery`.
- Response shapes: controllers usually pass simple arrays/objects to Inertia. Keep props small and serializable.
- DB usage: raw queries may appear (see `LotteryController::test` using `DB::table('lotteryResult')->get()`). Prefer Eloquent models for new features, but follow existing style in the touched files.

# Linting, testing, and CI hints

- JavaScript linting and formatting commands are defined in `package.json` (`fix:eslint`, `fix:prettier`).
- `composer.json` has useful composer scripts: `composer run compile` maps to `php artisan migrate:fresh --seed` (use with care).
- CI/Heroku: `package.json` includes `heroku-postbuild` mapped to `npm run build` — keep SSR build behavior in mind for deployment.

# Integration points & external deps

- Key PHP deps: `inertiajs/inertia-laravel`, `laravel/sanctum`, `laravel/framework`.
- Key JS deps: `@inertiajs/vue3`, `vite`, `vue`, `tailwindcss`, `laravel-vite-plugin`.
- Static images served via `ImagesController@show` (route `/img/{path}`) — updates to image handling should consider that controller.

# Editing guidance for AI agents

- When adding routes, update `routes/web.php` and create controller methods under `app/Http/Controllers`. Use `->name(...)` and appropriate middleware.
- When returning pages from controllers, prefer `Inertia::render('...')` and verify the Vue page exists under `resources/js/Pages`.
- Database changes: add migrations under `database/migrations` and, when relevant, add factory/seed changes under `database/factories` and `database/seeders`.
- Tests: put feature tests in `tests/Feature` and small unit tests in `tests/Unit`. Run `phpunit` locally.

# Where to look for examples

- Routes & controller patterns: `routes/web.php` and `app/Http/Controllers/*` (see `LotteryController.php` for a small, self-contained example).
- Frontend pages: `resources/js/Pages/*` and `resources/js/Shared/*` for shared components/layouts.
- DB and factories: `database/migrations`, `database/factories/*`, `database/seeders/DatabaseSeeder.php`.

---

If you'd like, I can (1) run a repo-wide search to collect more concrete examples, (2) merge any existing agent docs if you have them, or (3) tweak tone/length. Which would you prefer?
