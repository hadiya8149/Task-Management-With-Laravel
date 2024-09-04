<?php
namespace App\Services;
use App\Models\Task;
class TaskService {
    /**
     * @param array $taskDetails
     * 
     */
    public function createTasks(array $taskDetails): Task
    {
        $task = Task::create($taskDetails);
        return $task;
    }

    /**
     * @param 
     */

    public function editTask(array $taskData): Task
    {

        $taskId = $taskData['id'];
        $task = Task::find($taskId);
        $task->title = $taskData['title'];
        $task->description = $taskData['description'];
        $task->status = $taskData['status'];
        $task->tag = $taskData['tag'];
        $task->deadline = $taskData['deadline'];
        $task->documents = $taskData['documents'];

        $task->save();
        return $task;
    }
    }