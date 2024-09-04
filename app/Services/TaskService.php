<?php
namespace App\Services;
use App\Models\Task;
class TaskService {
    /**
     * @param array $taskDetails
     * @return Task
     */
    public function createTasks(array $taskDetails): Task
    {
        $task = Task::create($taskDetails);
        return $task;
    }

    
    /**
     * @param array $taskData
     * @return Task
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

    
    /**
     * @param array $taskData
     * @return Task
     */

    public function deleteTask(array $taskData): Task
    {
        
        $taskId = $taskData['id'];
        $task =  Task::find($taskId);
        $task->delete();
        return $task;
    }
    

    /**
     * @param array $taskData
     * @return Task
     */
    public function updateTask(array $taskData): Task
    {
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
            return $task;
        }
    }


    public function showTaskById(array $taskData): Task
    {
        
        $taskId = $validatedData['id'];
        $task = Task::find($taskId)->toArray();
        return $task;
    }
    }

