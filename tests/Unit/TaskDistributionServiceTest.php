<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TaskDistributionService;
use App\Services\DefaultTaskDistributionStrategy;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

class TaskDistributionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('developers.developers', [
            'DEV1' => ['speed' => 1],
            'DEV2' => ['speed' => 2],
        ]);
        Config::set('developers.max_hours_per_week', 45);

        Todo::factory()->create([
            'unique_id' => 'TASK1',
            'duration' => 10,
            'difficulty' => 2,
        ]);

        Todo::factory()->create([
            'unique_id' => 'TASK2',
            'duration' => 5,
            'difficulty' => 3,
        ]);

        Todo::factory()->create([
            'unique_id' => 'TASK3',
            'duration' => 8,
            'difficulty' => 1,
        ]);
    }

    /** @test */
    public function it_distributes_tasks_based_on_database_entries()
    {
        // servis instance
        $strategy = new DefaultTaskDistributionStrategy();
        $service = new TaskDistributionService($strategy);

        // Distribute tasks
        $result = $service->distributeTasksAndCalculateWeeks();

        $this->assertNotEmpty($result['distribution'], 'Distribution should not be empty');
        $this->assertEquals(1, $result['total_weeks'], 'Total weeks should be 1');

        // Check that tasks have been assigned
        $assignedTasks = [];
        foreach ($result['distribution'] as $week) {
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
}
