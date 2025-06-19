# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Essential Commands

### Development
```bash
# Start full development environment (includes server, queue worker, logs, and vite)
composer dev

# Start development with SSR support
composer dev:ssr

# Frontend development only
npm run dev

# Laravel development server only
php artisan serve
```

### Build & Production
```bash
# Build frontend assets
npm run build

# Build with SSR
npm run build:ssr

# Preview production build
npm run preview
```

### Testing
```bash
# Run all PHP tests
composer test
# or
php artisan test

# Run specific test suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Run specific test file
php artisan test tests/Feature/Auth/AuthenticationTest.php
```

### Code Quality
```bash
# PHP linting with Laravel Pint
./vendor/bin/pint

# JavaScript/TypeScript linting
npm run lint

# Format code with Prettier
npm run format

# Check formatting without changes
npm run format:check
```

## Architecture Overview

This is a **Laravel 12 + Vue 3** application using **Inertia.js** for SPA-like navigation without a separate API. Key architectural decisions:

### Tech Stack
- **Backend**: Laravel 12, PHP 8.2+, SQLite (default)
- **Frontend**: Vue 3, TypeScript, Vite, Tailwind CSS 4
- **Bridge**: Inertia.js 2.0 for seamless client-server communication
- **UI Components**: shadcn/vue, Headless UI, Reka UI, Heroicons, Lucide

### Request Flow
1. Laravel routes (`/routes/web.php`) define endpoints
2. Controllers return Inertia responses with page components and props
3. Inertia handles client-side routing and renders Vue components
4. Ziggy enables using Laravel routes in JavaScript (`route('name')`)

### Key Directories
- `/app/Http/Controllers` - Laravel controllers that return Inertia pages
- `/resources/js/pages` - Vue page components rendered by Inertia
- `/resources/js/components` - Reusable Vue components
- `/resources/js/components/ui` - shadcn/vue UI components
- `/resources/js/composables` - Vue composables for shared logic
- `/resources/js/layouts` - Layout components (App, Auth, Settings)
- `/resources/js/types` - TypeScript type definitions

### Frontend Patterns
- **TypeScript**: Strict mode enabled, all Vue components use `<script setup lang="ts">`
- **Imports**: Use `@/` alias for `/resources/js/` directory
- **Props**: Define using `defineProps<{}>()` with TypeScript interfaces
- **UI Components**: Prefer shadcn/vue components in `/components/ui`
- **Icons**: Use Lucide Vue Next for consistent iconography
- **Dark Mode**: Handled via `useAppearance` composable

### Backend Patterns
- **Controllers**: Return `Inertia::render('PageName', ['prop' => $data])`
- **Validation**: Use Form Request classes for complex validation
- **Authentication**: Built-in auth scaffolding with Inertia pages
- **Database**: Migrations in `/database/migrations`, factories for testing

### Testing Approach
- **PHP**: PHPUnit tests in `/tests/Feature` and `/tests/Unit`
- **Database**: Uses in-memory SQLite for test isolation
- **Assertions**: Use Laravel's built-in testing helpers and Inertia assertions