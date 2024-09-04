<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignedTask;
use App\Models\Task;

use App\Http\Requests\AssignTaskRequest;

class AssignedTaskController extends Controller

{
    public function __construct()
    {
        $this->middleware('jwt.verify');

        $this->middleware('role:manager')->except(['index']);
        $this->middleware('permission:assign task')->only(['assignTask']);
        $this->middleware('permission:remove assignee')->only(['deleteAssignedTask']);
        $this->middleware('permission:update assignee')->only(['editAssignedTask']);

    }
    public function index()
    {
        $allAssignedTasks = AssignedTask::all()->toArray();
        $message = 'assigned tasks lists';
        return sendJsonResponse(200, $message, $allAssignedTasks);
    }
    public function assignTask(AssignTaskRequest $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['task_id'];
        $userId = $validatedData['user_id'];
        // check if both don't exist then assign task other wise not
        AssignedTask::create([
            'task_id'=>$taskId,
            'user_id'=>$userId
        ]);

        return sendSuccessResponse("Task assigned successfully");
    }
    public function editAssignedTask(AssignTaskRequest $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['task_id'];
        $userId = $validatedData['user_id'];
        $assignedTask = AssignedTask::where('task_id',$taskId)->firstOrFail();
        $assignedTask->user_id = $userId;
        $assignedTask->save();
        return sendSuccessResponse("Task updated successfully");
    }
    public function deleteAssignedTask(AssignTaskRequest $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['task_id'];
        $userId = $validatedData['user_id'];

        $assignedTask = AssignedTask::where('task_id', $taskId)->where('user_id', $userId);
        $assignedTask->delete();
        return sendSuccessResponse("Assignee removed successfully");
    }
    public function showAssignedTaskByUser(Request $request)
    {
        $user_id = $request->user_id;
        $tasks = AssignedTask::find(5)->tasks->toArray();
        $message = "Tasks assigned to user id".$userId;
        return sendJsonResponse(200, $message, $tasks);
    }
}
