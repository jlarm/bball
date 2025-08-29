# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel-based basketball/sports organization management system built with Filament as the admin panel. The application manages organizations, seasons, and teams with a hierarchical structure where organizations contain seasons, and seasons contain teams.

## Development Commands

### Primary Development
- `composer run dev` - Start full development environment (server, queue, logs, and Vite)
- `composer run test` - Run PHPUnit test suite with configuration clearing
- `php artisan serve` - Start Laravel development server only
- `npm run dev` - Start Vite development server for asset compilation
- `npm run build` - Build production assets

### Database Operations
- `php artisan migrate` - Run database migrations
- `php artisan migrate:fresh --seed` - Fresh migration with seeding
- `php artisan db:seed` - Run database seeders

### Code Quality
- `vendor/bin/pint` - Run Laravel Pint for PHP code formatting (PSR-12)
- `php artisan test` - Run PHPUnit tests
- `php artisan config:clear` - Clear configuration cache

### Filament Commands
- `php artisan filament:upgrade` - Upgrade Filament resources (runs automatically on composer install)
- `php artisan make:filament-resource ModelName` - Generate Filament resource

## Architecture & Code Structure

### Core Models & Relationships
- **Organization**: Single-tenant organization model with singleton pattern (`Organization::current()`)
- **Season**: Belongs to organization, contains teams, uses soft deletes, has custom ordering by season/year
- **Team**: Belongs to season, represents individual teams within seasons

### Key Patterns
- **Singleton Organization**: Only one organization exists, accessed via `Organization::current()` or `Organization::currentOrDefault()`
- **UUID Fields**: All models use UUIDs alongside auto-incrementing IDs
- **Custom Scopes**: Season model has `orderBySeasonAndYear()` for intelligent season sorting
- **Soft Deletes**: Season model implements soft deletes for data retention

### Database
- Uses SQLite for development (`database/database.sqlite`)
- Migrations follow Laravel naming conventions with timestamps
- Key tables: `organizations`, `seasons`, `teams`, `users`

### Frontend & Admin
- **Filament Admin Panel**: Located at `/admin` route, amber color scheme
- **Vite Asset Pipeline**: Uses Vite with Tailwind CSS v4 and Laravel plugin
- **Authentication**: Filament handles admin authentication with Laravel's auth system

### File Organization
- Models: `app/Models/` - Eloquent models with relationships and business logic
- Admin Resources: Auto-discovered in `app/Filament/Resources/` (currently none exist)
- Migrations: `database/migrations/` with timestamp prefixes
- Frontend Assets: `resources/css/` and `resources/js/` compiled via Vite

## Development Workflow

1. Use `composer run dev` for full development environment including queue processing and log monitoring
2. Database uses SQLite for simplicity - migrations are automatically run on fresh installs
3. Filament admin panel is the primary interface - access at `localhost:8000/admin`
4. Follow Laravel conventions and PSR-12 via Pint for code formatting
5. Tests use in-memory SQLite database for isolation

## Testing

- PHPUnit configuration in `phpunit.xml`
- Tests separated into Unit (`tests/Unit/`) and Feature (`tests/Feature/`)
- Test database uses in-memory SQLite (`:memory:`)
- Run individual test files: `php artisan test --filter TestClassName`
- Test specific methods: `php artisan test --filter test_method_name`