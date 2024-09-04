<?php
namespace App\Services;
use App\Models\Task;

class AssignedTaskService 
{
    public function assignTask(array $taskData)
    {
        $taskId = $taskData['task_id'];
        $userId = $taskData['user_id'];
        // check if both don't exist then assign task other wise not
        AssignedTask::create([
            'task_id'=>$taskId,
            'user_id'=>$userId
        ]);

    }
    public function editAssignedTask(array $validatedData)
    {
        $taskId = $validatedData['task_id'];
        $userId = $validatedData['user_id'];
        $assignedTask = AssignedTask::where('task_id',$taskId)->firstOrFail();
        $assignedTask->user_id = $userId;
        $assignedTask->save();

    }
    public function deleteAssignedTask(array $vaidatedData)
    {
        $taskId = $validatedData['task_id'];
        $userId = $validatedData['user_id'];

        $assignedTask = AssignedTask::where('task_id', $taskId)->where('user_id', $userId);
        $assignedTask->delete();
    }

    public function showAssignedTaskByUser(int $id):string
    {
        $tasks = AssignedTask::find($id)->tasks->toArray();
        $message = "Tasks assigned to user id".$userId;
        return $message;
    }
}