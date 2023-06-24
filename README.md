## Steps to get started
The project uses Laravel 10 and PHP 8.1 and MySQL for the database.

1. Make sure all dependencies are installed and up to date by running `composer install`
2. Configure the database connection in the `.env` file by setting username, password and database name to match your local environment
3. Run `php artisan migrate` to create the database tables
4. Access the web application by running `php artisan serve` and visiting `http://localhost:8000` in your browser.
5. Run `php artisan schedule:work` to create and process tickets
6. Run `php artisan test` to run the test suite

You can import a postman collection to test all the endpoints by importing the `postman_collection.json` file in the root of the project.
