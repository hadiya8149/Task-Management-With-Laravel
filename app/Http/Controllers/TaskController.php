<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\AssignedTasks;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\RequireTaskId;
use App\Http\Requests\EditTaskRequest;

use App\Services\TaskService;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
        $this->middleware(['role:manager,api'])->only(['createTask', 'editTask', 'delete']);
        $this->middleware(['role:contributor,api', 'update_task.permission'])->only(['updateTask']);
    }
    /**
     * @param StoreTaskRequest $request
     * @param TaskService $taskService
     * @return Illuminate\Http\JsonResponse
     */
    public function createTask(StoreTaskRequest $request, TaskService $taskService)
    {
        $taskService->createTasks($request->validated());
        return sendSuccessResponse('Task created successfully');

    }

    public function index(Request $request)
    {
        $columns = ['title', 'description','status', 'tag', 'documents','updated_at'];
        $tasks = Task::all($columns)->toArray();
        return sendJsonResponse(200, "List of all tasks", $tasks);

    }
    public function showTaskById(RequireTaskId $request, TaskService $taskService)
    {
        $taskService->showTaskById($request->validated());
        return sendJsonResponse(200, "Task details", $task);
    }
    public function editTask(EditTaskRequest $request, TaskService $taskService)
    {
        $taskService->editTask($request->validated());
        return sendSuccessResponse("Task updated successfully");
    }
    public function delete(RequireTaskId $request, TaskService $taskService)
    {
        $taskService->deleteTask($request->validated());
        return sendSuccessResponse("Task deleted successfully");
    }

    public function updateTask(EditTaskRequest $request, TaskService $taskService)
    {
        $task = $taskSerive->updateTask($request->validated());
        
        if($task){
            sendSuccessResponse("Task updated successfully");
        }
        else{
            return sendForbiddenResponse();

        }
    }

}
