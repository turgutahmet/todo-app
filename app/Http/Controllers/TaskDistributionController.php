<?php

namespace App\Http\Controllers;

use App\Services\TaskDistributionService;
use Illuminate\Http\Response;

class TaskDistributionController extends Controller
{
    private TaskDistributionService $distributionService;

    public function __construct(TaskDistributionService $distributionService)
    {
        $this->distributionService = $distributionService;
    }

    public function index()
    {
        try {
            $result = $this->distributionService->distributeTasksAndCalculateWeeks();

            if (empty($result['distribution'])) {
                return view('task-distribution', [
                    'distribution' => [],
                    'total_weeks' => 0,
                ])->with('warning', 'No tasks found to distribute.');
            }

            return view('task-distribution', [
                'distribution' => $result['distribution'],
                'total_weeks' => $result['total_weeks'],
                'developerConfigs' => $result['developerConfigs'],
            ]);

        } catch (\Exception $e) {
            return response()->view('errors.500', [], 500);
        }
    }
}
