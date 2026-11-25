<?php

declare(strict_types=1);

namespace LaravelExamples\RequestValidation;

use PHPUnit\Framework\TestCase;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

final class ExampleTest extends TestCase
{
    private function validator(): OrderInput
    {
        return new OrderInput(new Factory(new Translator(new ArrayLoader(), 'en')));
    }

    public function testItReturnsOnlyValidatedFields(): void
    {
        $items = [['sku' => 'NOTEBOOK', 'quantity' => 2]];

        self::assertSame(['items' => $items], $this->validator()->validate([
            'items' => $items,
            'total' => 1,
        ]));
    }

    public function testItRejectsUnknownNestedKeysAndInvalidQuantities(): void
    {
        try {
            $this->validator()->validate([
                'items' => [['sku' => 'NOTEBOOK', 'quantity' => 0, 'price' => 1]],
            ]);
            self::fail('Invalid items should be rejected.');
        } catch (ValidationException $exception) {
            self::assertArrayHasKey('items.0', $exception->errors());
            self::assertArrayHasKey('items.0.quantity', $exception->errors());
        }
    }
}
