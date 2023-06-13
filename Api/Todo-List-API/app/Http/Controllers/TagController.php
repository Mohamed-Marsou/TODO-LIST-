<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TagController extends Controller
{

    public function index()
    {
        // Get the current date
        $today = Carbon::today()->toDateString();
    
        // Count all tasks
        $totalTasksCount = Task::count();
    
        // Get tasks with today's date
        $tasksToday = Task::whereDate('deadline', $today)->count();
    
        // Prepare the response data
        $response = [
            'total_tasks_count' => $totalTasksCount,
            'tasks_today' => $tasksToday,
            'today'=> $today
        ];
    
        // Return the response as JSON
        return response()->json($response);
    }

   public function getTagStatistics(): JsonResponse
{
    $tagStatistics = Task::join('tags', 'tasks.tag_id', '=', 'tags.id')
        ->whereNull('tasks.deleted_at')
        ->select('tags.name', 'tags.color', DB::raw('COUNT(tasks.tag_id) as count'))
        ->groupBy('tags.id', 'tags.color')
        ->get();

    return response()->json($tagStatistics);
}
}
