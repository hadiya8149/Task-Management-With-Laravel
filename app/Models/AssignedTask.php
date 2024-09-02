<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
class AssignedTask extends Model
{
    use HasFactory;
    protected $fillable = ['task_id', 'user_id'];
    protected $table = 'assigned_tasks';
    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

}
