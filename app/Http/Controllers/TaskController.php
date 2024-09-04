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
class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
        $this->middleware(['role:manager,api'])->only(['createTask', 'editTask', 'delete']);
        $this->middleware(['role:contributor,api', 'update_task.permission'])->only(['updateTask']);
        // $this->middleware(['permission:update assigned task'])->only(['updateTask']);
    }
    
    public function createTask(StoreTaskRequest $request)
    {

        // only a manager can create a task and assign to other users

        $validatedData = $request->validated();
        Task::create($validatedData);
        return sendSuccessResponse('Task created successfully');

    }
    public function index(Request $request)
    {
        $columns = ['title', 'description','status', 'tag', 'documents','updated_at'];
        $tasks = Task::all($columns)->toArray();
        return sendJsonResponse(200, "List of all tasks", $tasks);

    }
    public function showTaskById(RequireTaskId $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['id'];
        $task = Task::find($taskId)->toArray();
        return sendJsonResponse(200, "Task details", $task);
    }
    public function editTask(EditTaskRequest $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['id'];
        $task = Task::find($taskId);
        $task->title = $validatedData['title'];
        $task->description = $validatedData['description'];
        $task->status = $validatedData['status'];
        $task->tag = $validatedData['tag'];
        $task->deadline = $validatedData['deadline'];
        $task->documents = $validatedData['documents'];

        $task->save();
        return sendSuccessResponse("Task updated successfully");
    }
    public function delete(RequireTaskId $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['id'];
        $task =  Task::find($taskId);
        $task->delete();
        return sendSuccessResponse("Task deleted successfully");
    }

    public function updateTask(EditTaskRequest $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['id'];


        if($taskId){
            $task = Task::find($taskId);
            $task->title = $validatedData['title'];
            $task->description = $validatedData['description'];
            $task->status = $validatedData['status'];
            $task->tag = $validatedData['tag'];
            $task->deadline = $validatedData['deadline'];
            $task->documents = $validatedData['documents'];
            $task->save();
            sendSuccessResponse("Task updated successfully");
        }
        else{
            return sendForbiddenResponse();

        }
    }

}
