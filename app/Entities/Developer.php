<?php
namespace App\Entities;

class Developer
{
    public string $name;
    public int $speed;
    public float $maxHoursPerWeek;
    public float $totalAssignedHours;
    public array $totalTasks;
    public float $weeklyAssignedHours;
    public array $weeklyTasks;

    public function __construct(string $name, int $speed, float $maxHoursPerWeek)
    {
        $this->name = $name;
        $this->speed = $speed;
        $this->maxHoursPerWeek = $maxHoursPerWeek;
        $this->totalAssignedHours = 0.0;
        $this->totalTasks = [];
        $this->weeklyAssignedHours = 0.0;
        $this->weeklyTasks = [];
    }

    public function assignTask(Task $task, float $taskHours): void
    {
        $this->weeklyAssignedHours += $taskHours;
        $this->weeklyTasks[] = [
            'task' => $task,
            'developer_time' => $taskHours,
        ];
    }

    public function resetWeeklyData(): void
    {
        $this->weeklyAssignedHours = 0.0;
        $this->weeklyTasks = [];
    }

    public function updateTotalAssignedHours(): void
    {
        $this->totalAssignedHours += $this->weeklyAssignedHours;
        $this->totalTasks = array_merge($this->totalTasks, $this->weeklyTasks);
    }
}
