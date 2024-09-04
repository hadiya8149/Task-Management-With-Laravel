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
    
    public function assignTask(AssignTaskRequest $request, AssignedTaskService $assignedTaskService)
    {
        $assignedTaskService->assignTask($request->validated());
        return sendSuccessResponse("Task assigned successfully");
    }
    
    public function editAssignedTask(AssignTaskRequest $request, AssignedTaskService $assignedTaskService)
    {
        $assignedTaskService->editAssignedTask($request->validated());

        return sendSuccessResponse("Task updated successfully");
    }

    public function deleteAssignedTask(AssignTaskRequest $request, AssignedTaskService $assignedTaskService)
    {

        $validatedData = $request->validated();
        $assignedTaskService->deleteAssignedTask();
        return sendSuccessResponse("Assignee removed successfully");
    }
    public function showAssignedTaskByUser(Request $request, AssignedTaskService $assignedTaskService)
    {
        $user_id = $request->user_id;
        $message = $assignedTaskService->showAssignedTaskByUser();
        return sendJsonResponse(200, $message, $tasks);
    }
}
