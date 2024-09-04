<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\User;
class AssignedTask extends Model
{
    use HasFactory;
    
    protected $fillable = ['task_id', 'user_id'];
    protected $table = 'assigned_tasks';
    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
