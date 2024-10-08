<?php

namespace App\Factories;

use App\Interfaces\TodoProviderInterface;
use App\Services\MockOneProvider;
use App\Services\MockTwoProvider;

class TodoProviderFactory
{
    public static function create(string $provider): TodoProviderInterface
    {
        return match ($provider) {
            'mock-one' => new MockOneProvider(),
            'mock-two' => new MockTwoProvider(),
            default    => throw new \InvalidArgumentException("Invalid provider: {$provider}"),
        };
    }
}
