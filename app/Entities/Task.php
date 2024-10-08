<?php
namespace App\Entities;

class Task
{
    public int $id;
    public string $uniqueId;
    public int $duration;
    public int $difficulty;
    public int $workUnits;
    public int $remainingWorkUnits;

    public function __construct(int $id, string $uniqueId, int $duration, int $difficulty)
    {
        $this->id = $id;
        $this->uniqueId = $uniqueId;
        $this->duration = $duration;
        $this->difficulty = $difficulty;
        $this->workUnits = $this->calculateWorkUnits();
        $this->remainingWorkUnits = $this->workUnits;
    }

    private function calculateWorkUnits(): int
    {
        return $this->duration * $this->difficulty;
    }
}
