# Laravel Web Scraping Assessment

This assessment focuses on practical skills in web scraping using Laravel. The goal is to scrape movie details from IMDb's top chart, store them in a MySQL database, handle exceptions and use Laravel's task scheduling and queue system.

## Getting Started

Note: Project reuirements setup is php 8.1 and composer install in youur machine.

1. Clone this repository to your local environment.
2. Install the required Composer dependencies using `composer install`.
3. Copy the `.env.example` file to `.env` and configure your database settings.
4. Run database migrations using `php artisan migrate` to set up the database.
5. Start the development server using `php artisan serve` or visit http://localhost/web-scraper/public url.

## Running the Scraping Task

1. Access the route `/scrape` in your browser or use a tool like `curl` to trigger the scraping task.

## Viewing Scraped Movies

1. Access the route `/movies` to view the list of scraped movies stored in the database.

## Running Tests

1. Run unit tests using `php artisan test`.
2. Run tests with coverage report `php artisan test --coverage-html=coverage-report`

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
