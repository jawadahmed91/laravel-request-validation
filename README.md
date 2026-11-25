# Laravel Request Validation

Validate nested order inputs with Laravel. This example uses Laravel 13 and PHP 8.3 or later.

## Try it

```sh
composer install
composer test
```

In a Laravel controller, inject `OrderInput` and call `$orderInput->validate($request->all())`. Use the returned data to create the order and calculate prices from your catalog. The rules constrain the item list and reject extra keys inside each line. A JSON request with invalid data uses Laravel's standard 422 response.

## Add this to an existing Laravel project

1. Copy `src/OrderInput.php` into your application as `app/Validation/OrderInput.php`.
2. Change its namespace from `LaravelExamples\RequestValidation` to `App\Validation`.
3. Add the class to the controller constructor or action method. Laravel resolves its `Illuminate\Contracts\Validation\Factory` dependency automatically.

```php
use App\Validation\OrderInput;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

public function store(Request $request, OrderInput $orderInput): JsonResponse
{
    $validated = $orderInput->validate($request->all());

    // Calculate prices from your own catalog and persist the order here.

    return response()->json($validated, 201);
}
```

4. Register the controller route in `routes/api.php`.

```php
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::post('/orders', [OrderController::class, 'store']);
```

5. Send a valid request and confirm the endpoint accepts it.

```json
{
    "items": [
        {"sku": "NOTEBOOK", "quantity": 2}
    ]
}
```

6. Send an invalid request with an extra item key, duplicate SKU, empty list, or quantity outside `1` to `100`. Laravel should return a `422` JSON response containing field errors.
7. Copy `tests/ExampleTest.php` into your test suite, update its namespace and imports, and run `php artisan test`.
8. Adjust the rules in `OrderInput::validate()` to match your request fields. Keep prices and other trusted values on the server instead of accepting them from the client.

Read the [Laravel documentation](https://laravel.com/docs/13.x/validation).
