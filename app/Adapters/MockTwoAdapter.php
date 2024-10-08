<?php

namespace App\Adapters;

use App\Interfaces\TodoAdapterInterface;

class MockTwoAdapter implements TodoAdapterInterface
{
    public function adapt(array $data): array
    {
        return array_map(function ($item) {
            return [
                'id'         => $item['id'],
                'difficulty' => $item['zorluk'],
                'duration'   => $item['sure'],
                'provider'   => 'mock-two',
            ];
        }, $data);
    }
}
