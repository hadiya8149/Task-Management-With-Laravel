<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AssignedTaskController;
use Illuminate\Support\Facades\Password;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->group(function(){
    Route::post('signup', 'store')->name('signup');
    Route::post('login', 'login')->name('login');
});



Route::middleware(['jwt.verify'])->group(function(){
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/task', [TaskController::class, 'showTaskById']);

    // only managers can create edit or delete task
    Route::post('/create-task', [TaskController::class, 'createTask'])->middleware('permission:create task, api');
    Route::delete('/delete', [TaskController::class, 'delete']);
    Route::post('/edit-task', [TaskController::class, 'editTask']);
    // a contributor can edit his assigned tasks
    Route::post('/update-task', [TaskController::class, 'updateTask']);
});

Route::middleware('guest')->group(function()
{
    Route::post('/forgot_password', [ForgotPasswordController::class, 'submitForgotPasswordForm']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('password.update');

});


Route::get('/all-assigned-tasks', [AssignedTaskController::class, 'index']);
// only managers can assign task ,update assignee, remove assignee and view all assigned task to user
Route::middleware(['jwt.verify', 'role:manager,api'])->group(function(){
    Route::post('/assign-task', [AssignedTaskController::class, 'assignTask']);
    Route::post('/edit-assigned-task', [AssignedTaskController::class, 'editAssignedTask']);
    Route::delete('/delete-assigned-task', [AssignedTaskController::class, 'deleteAssignedTask']);
    Route::get('/get-all-task-assigned-to-user', [AssignedTaskController::class, 'showAssignedTaskByUser']);
});
Route::get('/user-permissions', [UserController::class, 'getPermissions']);
