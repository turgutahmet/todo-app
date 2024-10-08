<?php

namespace App\Interfaces;

use App\Entities\Task;
use App\Entities\Developer;

interface TaskDistributionStrategyInterface
{
    /**
     * Distributes tasks among developers over multiple weeks.
     */
    public function distributeTasks(array $tasksList, array $developers): array;
}
