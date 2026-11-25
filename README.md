# Laravel Request Validation

Validate nested order inputs with Laravel. This example uses Laravel 13 and PHP 8.3 or later.

## Try it

```sh
composer install
composer test
```

In a Laravel controller, inject `OrderInput` and call `$orderInput->validate($request->all())`. Use the returned data to create the order and calculate prices from your catalog. The rules constrain the item list and reject extra keys inside each line. A JSON request with invalid data uses Laravel's standard 422 response.

Read the [Laravel documentation](https://laravel.com/docs/13.x/validation).
