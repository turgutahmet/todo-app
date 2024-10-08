<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\DefaultTaskDistributionStrategy;
use App\Entities\Task;
use App\Entities\Developer;

class DefaultTaskDistributionStrategyTest extends TestCase
{
    /** @test */
    public function it_distributes_tasks_among_developers()
    {
        // basit task olustur
        $tasks = [
            new Task(1, 'TASK1', 10, 2),
            new Task(2, 'TASK2', 5, 3),
            new Task(3, 'TASK3', 8, 1),
        ];

        // developer olustur
        $developers = [
            'DEV1' => new Developer('DEV1', 1, 45),
            'DEV2' => new Developer('DEV2', 2, 45),
        ];

        $strategy = new DefaultTaskDistributionStrategy();

        // Distribute tasks
        $weeks = $strategy->distributeTasks($tasks, $developers);

        $this->assertNotEmpty($weeks, 'Weeks should not be empty');
        $this->assertArrayHasKey('Week 1', $weeks, 'Week 1 should be in the distribution');
        $this->assertCount(1, $weeks, 'There should be only 1 week');

        // Check that tasks have been assigned
        $assignedTasks = [];
        foreach ($weeks as $week) {
            foreach ($week as $developerData) {
                foreach ($developerData['tasks'] as $taskInfo) {
                    $assignedTasks[] = $taskInfo['task']->uniqueId;
                }
            }
        }

        $this->assertCount(3, $assignedTasks, 'All tasks should be assigned');
        $this->assertContains('TASK1', $assignedTasks);
        $this->assertContains('TASK2', $assignedTasks);
        $this->assertContains('TASK3', $assignedTasks);
    }

    /** @test */
    public function it_handles_tasks_exceeding_developer_capacity()
    {
        // basit task olustur, developerin kapasitesini asacak sekilde
        $tasks = [
            new Task(1, 'TASK1', 100, 1), // is gucu = 100
        ];

        // limitli developer olustur
        $developers = [
            'DEV1' => new Developer('DEV1', 1, 45),
        ];


        $strategy = new DefaultTaskDistributionStrategy();

        // Distribute tasks
        $weeks = $strategy->distributeTasks($tasks, $developers);

        $this->assertNotEmpty($weeks, 'Weeks should not be empty');
        $this->assertCount(3, $weeks, 'It should take 3 weeks');

        // Verify the task is split over multiple weeks
        $totalAssignedHours = 0;
        foreach ($weeks as $week) {
            foreach ($week as $developerData) {
                $totalAssignedHours += $developerData['total_hours'];
            }
        }

        $this->assertEquals(100, $totalAssignedHours, 'Total assigned hours should be equal to task work units');
    }
}
