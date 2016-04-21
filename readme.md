# Spark Installation

1. `laravel new project`
2. `cd project`
3. `git clone https://github.com/taylorotwell/spark spark`

Next, update your `composer.json` like so:

    "repositories": [
        {
            "type": "path",
            "url": "./spark"
        }
    ],
    "minimum-stability": "dev",
    "prefer-stable": true

4. Add `"laravel/spark": "*@dev"` to the `require` section of your `composer.json`
4. `composer update`
5. Add `Laravel\Spark\Providers\SparkServiceProvider` to service provider array in `app.php`
6. `php artisan spark:install`
7. Add `App\Providers\SparkServiceProvider` to service provider array in `app.php`
8. `npm install`
9. `gulp`
10. Set environment variables at bottom of `.env` file.
11. Configure Stripe plans in `App\Providers\SparkServiceProvider`
12. `php artisan migrate`
13. Hit application in web browser.
14. After creating account, add your e-mail address to `$developers` array in `App\Spark\SparkServiceProvider`
