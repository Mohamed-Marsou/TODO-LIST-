<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/mytasks', [TaskController::class, 'index'])->name('task.index');
Route::post('/newtask', [TaskController::class, 'store'])->name('task.store');
Route::post('/tasks/{id}/delete', [TaskController::class, 'destroy'])->name('task.destroy');
Route::post('/tasks/{id}/undo', [TaskController::class, 'undoTaskRemoval'])->name('task.undoTaskRemoval');


// Tag
Route::get('/task/details', [TagController::class, 'index'])->name('tag.index');
Route::get('/tag/statistics', [TagController::class, 'getTagStatistics'])->name('tag.getTagStatistics');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
