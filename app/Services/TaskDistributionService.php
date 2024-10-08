<?php

namespace App\Services;

use App\Entities\Task;
use App\Entities\Developer;
use App\Models\Todo;
use App\Interfaces\TaskDistributionStrategyInterface;

class TaskDistributionService
{
    private TaskDistributionStrategyInterface $strategy;
    private array $developerConfigs;
    private float $maxHoursPerWeek;

    public function __construct(TaskDistributionStrategyInterface $strategy)
    {
        $this->strategy = $strategy;

        // Load configurations from config 'developers.php'
        $this->developerConfigs = config('developers.developers');
        $this->maxHoursPerWeek = config('developers.max_hours_per_week');
    }
    /* gorevleri gelistiriciler arasinda dagitir ve gereken toplam hafta saysini hesapla
     * */
    public function distributeTasksAndCalculateWeeks(): array
    {
        $tasks = $this->getPreparedTasks();
        $developers = $this->initializeDevelopers();
        $weeks = $this->strategy->distributeTasks($tasks, $developers);

        return [
            'distribution' => $weeks,
            'total_weeks' => count($weeks),
            'developerConfigs' => $this->developerConfigs,
        ];
    }
    /* gorevleri db den al ve hazirla
     * */
    private function getPreparedTasks(): array
    {
        $todos = Todo::select(['id', 'unique_id', 'duration', 'difficulty'])
            ->orderByDesc(Todo::raw('difficulty * duration'))
            ->get();

        return $todos->map(function ($todo) {
            return new Task($todo->id, $todo->unique_id, $todo->duration, $todo->difficulty);
        })->toArray();
    }

    /* gelistiricleri yapilandirmalara gore baslat
     * */
    private function initializeDevelopers(): array
    {
        $developers = [];

        foreach ($this->developerConfigs as $name => $config) {
            $developers[$name] = new Developer($name, $config['speed'], $this->maxHoursPerWeek);
        }

        return $developers;
    }
}
