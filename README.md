# Mikroliterasi

Mikroliterasi is a web-based platform for organizing, documenting, and presenting research activities, publications, researchers, and teaching materials.

The platform is designed to support research-oriented organizations and academic teams in maintaining a structured public presence while providing authenticated users with tools for managing research content.

## Features

- Research area management
- Research project management
- Publication management
- Researcher and contributor profiles
- Teaching material management
- Public research and publication pages
- Role-based access control
- Dashboard for authenticated users
- Media and document management
- SEO-friendly public URLs using slugs
- Responsive interface for desktop and mobile devices

## Technology Stack

Mikroliterasi is built with:

- **Laravel 13**
- **PHP 8.5+**
- **Blade**
- **Tailwind CSS 4**
- **Vite**
- **MySQL / MariaDB**
- **Composer**
- **Node.js and npm**

The application follows Laravel's standard project structure and uses a service-oriented application architecture where appropriate.

## Requirements

Before installing Mikroliterasi, make sure the development environment provides:

- PHP 8.5 or later
- Composer
- Node.js 20 or later
- npm
- MySQL or MariaDB
- Git
- PHP extensions required by Laravel and the application's dependencies

You can verify the installed versions with:

```bash
php --version
composer --version
node --version
npm --version
git --version
```

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd mikroliterasi
```

Install PHP dependencies:

```bash
composer install
```

Create the local environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database and other environment variables in `.env`.

For example:

```dotenv
APP_NAME=Mikroliterasi
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mikroliterasi
DB_USERNAME=root
DB_PASSWORD=
```

Run the database migrations:

```bash
php artisan migrate
```

If the application provides seed data, run:

```bash
php artisan db:seed
```

Install frontend dependencies:

```bash
npm install
```

Build the frontend assets:

```bash
npm run build
```

## Local Development

Mikroliterasi uses Laravel's standard `public/` directory as its local web root.

The application can be served directly using PHP's built-in web server:

```bash
php -S 127.0.0.1:8000 -t public
```

Then open:

```text
http://127.0.0.1:8000
```

During frontend development, Vite can be run with:

```bash
npm run dev
```

## Environment Configuration

Environment-specific configuration is kept outside the repository.

The `.env` file should never be committed to Git.

For local development:

```dotenv
APP_ENV=local
APP_DEBUG=true
```

For production:

```dotenv
APP_ENV=production
APP_DEBUG=false
```

Production credentials, application keys, database credentials, mail configuration, and other sensitive values must be configured directly on the production server.

## Production Deployment

The repository maintains the standard Laravel directory structure. The application itself remains independent from the hosting provider's document root configuration.

On the production server, the application can be deployed outside the web-accessible document root:

```text
/home/mikrolite/
├── laravel/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   └── vendor/
│
└── public_html/
```

The production application can dynamically use the hosting provider's public directory while preserving Laravel's standard `public/` directory for local development.

This behavior is configured in `bootstrap/app.php`:

```php
->registered(function ($app): void {
    if ($app->environment('production')) {
        $publicPath = realpath(base_path('/../public_html'));

        if ($publicPath !== false) {
            $app->usePublicPath($publicPath);
        }
    }
})
```

As a result:

- Local development uses `project/public`.
- Production uses the configured `public_html` directory.
- The Git repository retains the standard Laravel structure.
- The application code remains outside the publicly accessible document root.

## Deployment Workflow

The intended deployment workflow is:

```text
Local development
       │
       ▼
Git commit
       │
       ▼
GitHub
       │
       ▼
Production server
       │
       ▼
git pull
       │
       ├── Composer dependencies
       ├── Frontend build
       ├── Database migrations
       └── Laravel optimization
```

A typical production update consists of:

```bash
git pull origin main

composer install --no-dev --optimize-autoloader

npm ci
npm run build

php artisan migrate --force
php artisan optimize
```

Production deployment should be performed carefully when database migrations or application changes may affect existing data.

## Application Structure

The main application areas include:

```text
app/
├── Http/
├── Models/
├── Policies/
└── Services/

resources/
└── views/

routes/
└── web.php

database/
├── migrations/
└── seeders/

public/
└── ...
```

The application uses Laravel's MVC conventions together with policies for authorization and service classes for application-specific business logic.

## Access Control

Mikroliterasi provides role-based access to administrative functionality.

Public users can access published research content, publications, researcher profiles, and other public resources.

Authenticated users receive permissions according to their assigned role. Authorization is enforced through Laravel policies and application-level access controls.

Sensitive management operations are restricted to authorized users.

## Data and Media

Uploaded media and application-generated files are managed through Laravel's storage system.

The application uses Laravel's public storage mechanism where appropriate:

```bash
php artisan storage:link
```

Production storage configuration should be verified after deployment to ensure uploaded files are accessible through the intended public paths.

## Security

The following files and values must not be committed to the repository:

- `.env`
- Application keys
- Database credentials
- Mail credentials
- API keys
- Other production secrets

Before deploying to production, ensure:

```dotenv
APP_ENV=production
APP_DEBUG=false
```

Laravel's production configuration should also use appropriate database credentials, filesystem permissions, and HTTPS configuration.

## Development Guidelines

When contributing to Mikroliterasi:

1. Keep the standard Laravel project structure.
2. Do not commit environment-specific configuration.
3. Do not commit secrets or credentials.
4. Use migrations for database schema changes.
5. Use policies for authorization rules.
6. Keep business logic out of Blade templates where practical.
7. Test application changes locally before pushing them to the production branch.
8. Keep production-specific hosting configuration isolated from local development.

## License

This project is maintained as part of the Mikroliterasi research and education platform.

The applicable license and terms of use should be defined by the project maintainers.
