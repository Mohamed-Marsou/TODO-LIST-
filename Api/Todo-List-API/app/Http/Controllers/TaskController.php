<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::with('tag')->get();
        return response()->json($tasks);
    }

    // store new Task 
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'color' => 'string',
            'tag' => 'required|string',
            'deadline' => 'required',
            'user_id' => 'integer',
        ]);
        
        $tag = Tag::firstOrCreate(['name' => $validatedData['tag']]);
        
        if (!$tag->wasRecentlyCreated) {
            // The tag already exists, retrieve its color from the database
            $validatedData['color'] = $tag->color;
        } else {
            // The tag is newly created, assign the provided color or a default color
            $validatedData['color'] = $validatedData['color']; // Replace 'green' with your default color value
            $tag->color = $validatedData['color'];
            $tag->save();
        }
        
    
        $task = Task::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'tag_id' => $tag->id,
            'deadline' => $validatedData['deadline'],
            'user_id' => $validatedData['user_id'],
        ]);
    
        return response()->json($task, 201);
    }
    
    

    public function destroy($id): JsonResponse{
        $task = Task::findOrFail($id);
        $task->delete();
    
        return response()->json(['message' => 'Task deleted'], 201);
    }

    
    public function undoTaskRemoval($id): JsonResponse
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();
    
        return response()->json(['message' => 'Task removal undone'], 201);
    }
}
