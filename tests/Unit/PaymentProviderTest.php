<?php

namespace Tests\Unit;

use App\Http\Factories\PaymentProviderFactory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PaymentProviderTest extends TestCase
{
    use RefreshDatabase;

    public static function classesListProvider(): array
    {
        return [
           [
               'CheckoutA',
               'CheckoutB'
           ]
        ];
    }

    #[DataProvider('classesListProvider')]
    public function test_payment_provider_factory($classesList): void
    {
        $factory = PaymentProviderFactory::handle($classesList);
        $this->assertInstanceOf('App\Strategies\CheckoutA', $factory,'');
    }


}
