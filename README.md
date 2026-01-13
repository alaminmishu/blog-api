# Blog API

A production-ready RESTful API for a blogging platform built with Laravel 12.

## Features

- ✅ Authentication with Laravel Sanctum
- ✅ Posts, Categories, Tags (many-to-many)
- ✅ Authorization policies (only owners can edit)
- ✅ Admin role system
- ✅ 17 passing tests
- ✅ Professional API documentation with Scribe
- ✅ 24 endpoints

## Tech Stack

- Laravel 12
- PHP 8.4
- MySQL
- Sanctum for API authentication
- PHPUnit for testing
- Scribe for API documentation

## API Documentation

Visit: `https://your-domain.com/docs`

## Installation

\`\`\`bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
\`\`\`

## Testing

\`\`\`bash
php artisan test
\`\`\`

## Endpoints

See full documentation at `/docs`

### Authentication
- POST `/api/v1/register`
- POST `/api/v1/login`
- POST `/api/v1/logout`

### Posts (Protected)
- GET `/api/v1/posts`
- POST `/api/v1/posts`
- GET `/api/v1/posts/{id}`
- PUT `/api/v1/posts/{id}`
- DELETE `/api/v1/posts/{id}`

[... more endpoints ...]

## Author

Built by [Your Name] as part of Laravel learning journey.

## License

MIT
