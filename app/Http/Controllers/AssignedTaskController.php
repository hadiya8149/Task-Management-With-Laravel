<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignedTask;
use App\Http\Requests\AssignTaskRequest;
class AssignedTaskController extends Controller
{
    public function index()
    {
        $allAssignedTasks = AssignedTask::all();
        return resosne()->json([
            'assigned tasks'=>$allAssignedTasks
        ]);
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
        return response()->json([
            'message'=>'Task assigned successfully'
        ]);
    }
    public function editAssignedTask(AssignTaskRequest $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['task_id'];
        $userId = $validatedData['user_id'];
        $assignedTask = AssignedTask::where('task_id',$taskId)->firstOrFail();
        $assignedTask->user_id = $userId;
        $assignedTask->save();
        return response()->json([
            'message'=>'Assignee updated successfully'
        ]);
    }
    public function deleteAssignedTask(AssignTaskRequest $request)
    {
        $validatedData = $request->validated();
        $taskId = $validatedData['task_id'];
        $userId = $validatedData['user_id'];

        $assignedTask = AssignedTask::where('task_id', $taskId)->where('user_id', $userId);
        $assignedTask->delete();
        return response()->json([
            'message'=>'assignee removed successfully'
        ]);
    }
}
