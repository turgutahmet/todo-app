<?php
namespace App\Services;

use App\Interfaces\TodoProviderInterface;
use App\Adapters\MockOneAdapter;
use Illuminate\Support\Facades\Http;
use App\Interfaces\TodoAdapterInterface;

class MockOneProvider implements TodoProviderInterface
{
    private TodoAdapterInterface $adapter;

    public function __construct()
    {
        $this->adapter = new MockOneAdapter();
    }

    public function getTodos(): array
    {
        $response = Http::get('https://raw.githubusercontent.com/WEG-Technology/mock/main/mock-one');
        $data = json_decode($response->body(), true);

        if (!is_array($data)) {
            throw new \RuntimeException('Invalid response from MockOne API');
        }

        return $this->adapter->adapt($data);
    }
}
