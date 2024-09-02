<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\RequireTaskId;
use App\Http\Requests\EditTaskRequest;
class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }
    
    public function createTask(StoreTaskRequest $request)
    {

        // only a manager can create a task and assign to other users

        $validatedData = $request->validated();
        Task::create($validatedData);
        return response()->json([
            'message'=>'Task created successfully',
        ], 201);

    }
    public function index(Request $request)
    {
        $columns = ['title', 'description','status', 'tag', 'documents','updated_at'];
        $tasks = Task::all($columns);
        return response()->json([
            'tasks'=>$tasks
        ]);

    }
    public function showTaskById(RequireTaskId $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['id'];
        $task = Task::find($taskId);
        return response()->json([
            'task'=>$task
        ]);
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
        return response()->json([
            'message'=>'Task updated successfully'
        ]);
    }
    public function delete(RequireTaskId $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['id'];
        $task =  Task::find($taskId);
        $task->delete();
        return response()->json(
            [
                'message'=>"Task deleted successfully"
            ]
            );
    }
}
