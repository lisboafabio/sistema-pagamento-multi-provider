<?php

namespace App\Http\Factories;

use App\Interfaces\PaymentProviderInterface;

class PaymentProviderFactory
{
    public static function handle(string $provider)
    {
        $class = "App\Strategies\\$provider";

        if (class_exists($class) && is_subclass_of($class, PaymentProviderInterface::class)) {
            return app($class);
        }

        return throw new \InvalidArgumentException("Class {$provider} does not exist");
    }

}
