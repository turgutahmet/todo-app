<?php

namespace App\Services;

use App\Factories\TodoProviderFactory;

class TodoAggregatorService
{
    public function getAllTodos(): array
    {
        $providers = ['mock-one', 'mock-two'];
        $allTodos  = [];

        foreach ($providers as $providerName) {
            $provider = TodoProviderFactory::create($providerName);
            $todos    = $provider->getTodos();
            $allTodos = array_merge($allTodos, $todos);
        }

        return $allTodos;
    }
}
