<?php

namespace App\Console\Commands;

use App\Models\Todo;
use App\Services\TodoAggregatorService;
use Illuminate\Console\Command;

class FetchTodos extends Command
{
    protected $signature   = 'todos:fetch';
    protected $description = 'Fetch todos from all providers and save to database';

    public function handle(TodoAggregatorService $aggregator)
    {
        $todos = $aggregator->getAllTodos();

        foreach ($todos as $todo) {
            $uniqueId = $todo['provider'] . '_' . $todo['id'];
            Todo::updateOrCreate(
                ['unique_id' => $uniqueId],
                [
                    'id'         => $todo['id'],
                    'difficulty' => $todo['difficulty'],
                    'duration'   => $todo['duration'],
                    'provider'   => $todo['provider'],
                ]
            );
        }

        $this->info('Todos fetched and saved successfully.');
    }
}
