<?php

declare(strict_types=1);

namespace LaravelExamples\RequestValidation;

use Illuminate\Contracts\Validation\Factory;

final class OrderInput
{
    public function __construct(private readonly Factory $validation)
    {
    }

    public function validate(array $input): array
    {
        return $this->validation->make($input, [
            'items' => ['required', 'array', 'list', 'min:1', 'max:50'],
            'items.*' => ['required', 'array:sku,quantity'],
            'items.*.sku' => ['required', 'string', 'max:40', 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'between:1,100'],
        ])->validate();
    }
}
