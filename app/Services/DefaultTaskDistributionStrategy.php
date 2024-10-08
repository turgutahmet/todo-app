<?php

namespace App\Services;

use App\Interfaces\TaskDistributionStrategyInterface;
use App\Entities\Task;
use App\Entities\Developer;

class DefaultTaskDistributionStrategy implements TaskDistributionStrategyInterface
{
    public function distributeTasks(array $tasksList, array $developers): array
    {
        $weeks = [];
        $weekIndex = 1;

        while (!empty($tasksList)) {
            // Reset developer weekly data
            foreach ($developers as $developer) {
                $developer->resetWeeklyData();
            }

            $weekAssignments = $this->distributeTasksForWeek($tasksList, $developers);

            if (empty($weekAssignments)) {
                // If no tasks were assigned this week, weekIndex ++
                $weekIndex++;
                continue;
            }

            // Update developers' total assigned hours and tasks
            foreach ($developers as $developer) {
                $developer->updateTotalAssignedHours();
            }

            $weeks["Week {$weekIndex}"] = $weekAssignments;
            $weekIndex++;
        }

        return $weeks;
    }
    private function distributeTasksForWeek(array &$tasksList, array &$developers): array
    {
        $weekAssignments = [];
        $tasksAssignedThisWeek = false;

        do {
            $taskAssignedInIteration = false;

            foreach ($tasksList as $taskKey => $task) {
                $bestAssignment = $this->findBestDeveloperForTask($task, $developers);

                if ($bestAssignment) {
                    $this->assignTaskToDeveloper($tasksList, $taskKey, $developers, $weekAssignments, $bestAssignment);
                    $taskAssignedInIteration = true;
                    $tasksAssignedThisWeek = true;
                    break; // Re-evaluate workloads
                }
            }
        } while ($taskAssignedInIteration);

        return $tasksAssignedThisWeek ? $weekAssignments : [];
    }

    /* Gorevi atayacak en iyi gelistiriciyi bulur ve atanan toplam saat sayisini en aza indirmeyi hedefler
     * */
    private function findBestDeveloperForTask(Task $task, array $developers): ?array
    {
        $bestAssignment = null;
        $minMaxTotalHours = null;

        foreach ($developers as $developer) {
            $availableHours = $developer->maxHoursPerWeek - $developer->weeklyAssignedHours;
            if ($availableHours <= 0) {
                continue;
            }

            $possibleWorkUnits = $availableHours * $developer->speed;
            $workUnitsToAssign = min($task->remainingWorkUnits, $possibleWorkUnits);
            $taskHours = $workUnitsToAssign / $developer->speed;
            // gorev atanirsa yeni toplam atanan saatleri hesapla
            $newTotalAssignedHours = $developer->totalAssignedHours + $developer->weeklyAssignedHours + $taskHours;
            //tum gelistiriciler arasinda atanan maksimum toplam saati bul
            $maxTotalHours = $newTotalAssignedHours;

            foreach ($developers as $otherDeveloper) {
                if ($otherDeveloper !== $developer) {
                    $otherTotalHours = $otherDeveloper->totalAssignedHours + $otherDeveloper->weeklyAssignedHours;
                    $maxTotalHours = max($maxTotalHours, $otherTotalHours);
                }
            }
            //bu atamanin toplam atanan max saati en aza indirip indirmedigini kontrol edelim
            if ($minMaxTotalHours === null || $maxTotalHours < $minMaxTotalHours) {
                $minMaxTotalHours = $maxTotalHours;
                $bestAssignment = [
                    'developer' => $developer,
                ];
            }
        }

        return $bestAssignment;
    }

    private function assignTaskToDeveloper(array &$tasksList, int $taskKey, array &$developers, array &$weekAssignments, array $assignment): void
    {
        $developer = $assignment['developer'];
        $availableHours = $developer->maxHoursPerWeek - $developer->weeklyAssignedHours;

        $task = $tasksList[$taskKey];
        //bu hafta ne kadar is verilecegini hesapla
        $possibleWorkUnits = $availableHours * $developer->speed;
        //mumkun oldukca cok atama yapilsin
        $workUnitsAssigned = min($task->remainingWorkUnits, $possibleWorkUnits);
        $taskHours = $workUnitsAssigned / $developer->speed;

        //gorevin kalan is birimlerini guncelle
        $task->remainingWorkUnits -= $workUnitsAssigned;

        $developer->assignTask($task, $taskHours);

        $weekAssignments[$developer->name]['tasks'][] = [
            'task' => $task,
            'developer_time' => $taskHours,
        ];

        $weekAssignments[$developer->name]['total_hours'] = ($weekAssignments[$developer->name]['total_hours'] ?? 0) + $taskHours;
        // Gorev tamamlandiysa gorevi listeden cikar
        if ($task->remainingWorkUnits <= 0) {
            unset($tasksList[$taskKey]);
        }
    }

}
