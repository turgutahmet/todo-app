<?php
namespace App\Services;

use App\Interfaces\TodoProviderInterface;
use App\Adapters\MockTwoAdapter;
use Illuminate\Support\Facades\Http;
use App\Interfaces\TodoAdapterInterface;

class MockTwoProvider implements TodoProviderInterface
{
    private TodoAdapterInterface $adapter;

    public function __construct()
    {
        $this->adapter = new MockTwoAdapter();
    }

    public function getTodos(): array
    {
        $response = Http::get('https://raw.githubusercontent.com/WEG-Technology/mock/main/mock-two');
        $data = json_decode($response->body(), true);

        if (!is_array($data)) {
            throw new \RuntimeException('Invalid response from MockTwo API');
        }

        return $this->adapter->adapt($data);
    }
}
