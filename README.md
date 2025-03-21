# BooKoo - E-Library Management System


## About BooKoo

BooKoo is a modern e-library management system built with Laravel 11. It provides a comprehensive solution for managing digital books, user subscriptions, and reading analytics. The system allows users to browse, search, and read books online, while administrators can manage the library catalog, track user activity, and generate reports.

## Features

- **User Authentication & Management**
  - Role-based access control (Admin, Librarian, Reader)
  - User profiles with reading preferences and history
  - Social authentication options

- **Book Management**
  - Comprehensive book metadata
  - Multiple format support (PDF, EPUB, MOBI)
  - Cover image management
  - Categories and tags
  - Search functionality with advanced filters

- **Reading Experience**
  - In-browser reader for supported formats
  - Bookmarking and annotations
  - Reading progress tracking
  - Night mode and font customization

- **Admin Dashboard**
  - User management
  - Content moderation
  - Analytics and reporting
  - System configuration

- **API Support**
  - RESTful API for third-party integrations
  - API documentation with Swagger

## Requirements

- PHP 8.2+
- Composer 2.0+
- MySQL 8.0+ / PostgreSQL 13.0+
- Node.js 18.0+ and npm
- Redis (for queues and caching)

## Installation

1. Clone the repository
```bash
git clone https://github.com/yourusername/bookoo.git
cd bookoo
```

2. Install dependencies
```bash
composer install
npm install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in the `.env` file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookoo
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations and seed the database
```bash
php artisan migrate --seed
```

6. Compile assets
```bash
npm run dev
```

7. Start the development server
```bash
php artisan serve
```

## Development

### Directory Structure

- `app/` - Contains the core code of the application
- `config/` - Contains all configuration files
- `database/` - Contains database migrations and seeders
- `public/` - Contains publicly accessible files
- `resources/` - Contains views, raw assets, and localization files
- `routes/` - Contains all route definitions
- `storage/` - Contains compiled Blade templates, sessions, and file uploads
- `tests/` - Contains test cases

### Commands

- `php artisan test` - Run tests
- `php artisan route:list` - List all registered routes
- `php artisan make:model ModelName -mcr` - Create a model with migration, controller, and resource
- `php artisan storage:link` - Create a symbolic link from public/storage to storage/app/public

## Deployment

1. Set up your production environment with appropriate server requirements
2. Clone the repository to your production server
3. Install dependencies (composer install --no-dev)
4. Configure environment variables for production
5. Run migrations
6. Compile assets for production (npm run build)
7. Set up a web server (Nginx/Apache) to point to the public directory
8. Configure queue workers and scheduled tasks

## Security

- Keep your dependencies up to date
- Use HTTPS in production
- Set proper file permissions
- Configure CORS if using the API
- Review Laravel security best practices

## Testing

The application includes unit and feature tests. Run them with:

```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create a feature branch (git checkout -b feature/your-feature)
3. Commit your changes (git commit -m 'Add some feature')
4. Push to the branch (git push origin feature/your-feature)
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Credits

- [Laravel](https://laravel.com/) - The PHP framework used
- [Tailwind CSS](https://tailwindcss.com/) - For responsive styling
- [ChartJS](https://chartjs.com/) - For chart styling
- [EPUB.js](https://github.com/futurepress/epub.js/) - For EPUB reader functionality

## Contact

For support or questions, please contact:
- Email: support@bookoo-library.com
- GitHub Issues: https://github.com/yourusername/bookoo/issues