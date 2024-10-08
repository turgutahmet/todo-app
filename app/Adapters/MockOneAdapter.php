<?php

namespace App\Adapters;

use App\Interfaces\TodoAdapterInterface;

class MockOneAdapter implements TodoAdapterInterface
{
    public function adapt(array $data): array
    {
        return array_map(function ($item) {
            return [
                'id'         => $item['id'],
                'difficulty' => $item['value'],
                'duration'   => $item['estimated_duration'],
                'provider'   => 'mock-one',
            ];
        }, $data);
    }
}
