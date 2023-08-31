# Laravel Web Scraping Assessment

This assessment focuses on practical skills in web scraping using Laravel. The goal is to scrape movie details from IMDb's top chart, store them in a MySQL database, handle exceptions and use Laravel's task scheduling and queue system.

## Getting Started

1. Clone this repository to your local environment.
2. Install the required Composer dependencies using `composer install`.
3. Copy the `.env.example` file to `.env` and configure your database settings.
4. Run database migrations using `php artisan migrate` to set up the database.
5. Start the development server using `php artisan serve`.

## Running the Scraping Task

1. Access the route `/scrape` in your browser or use a tool like `curl` to trigger the scraping task.

## Viewing Scraped Movies

1. Access the route `/movies` to view the list of scraped movies stored in the database.

## Running Tests

1. Run unit tests using `php artisan test`.
2. Run tests with coverage report `php artisan test --coverage-html=coverage-report`
