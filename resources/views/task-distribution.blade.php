<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Distribution</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-6 text-center text-indigo-700">Task Distribution</h1>
    <p class="mb-6 text-center text-lg text-gray-600">Total Weeks: {{ $total_weeks }}</p>

    @foreach($distribution as $week => $developers)
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-indigo-600 border-b pb-2">{{ $week }}</h2>
            @foreach($developers as $developerName => $data)
                <div class="mt-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $developerName }}</h3>
                    <ul class="space-y-2">
                        @foreach($data['tasks'] as $taskInfo)
                                <?php
                                /** @var \App\Entities\Task $task */
                                $task = $taskInfo['task'];
                                $developerTime = $taskInfo['developer_time'];
                                ?>
                            <li class="bg-gray-50 rounded-md shadow-sm">
                                <span class="font-medium">ID: {{ $task->uniqueId }}</span> |
                                <span class="text-indigo-600">Difficulty: {{ $task->difficulty }}</span> |
                                <span class="text-green-600">Duration: {{ $task->duration }}h</span> |
                                <span class="text-blue-600">Developer Time: {{ number_format($developerTime, 2) }}h</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="font-semibold text-right text-gray-700">Total Hours: {{ number_format($data['total_hours'], 2) }}h</p>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
</body>
</html>
