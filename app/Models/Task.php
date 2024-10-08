<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\AssignedTask;
class Task extends Model
{
    use HasApiTokens;
    use HasFactory;
    use  Notifiable;
    use  HasRoles;
    
    protected $fillable = ['title', 'description', 'status', 'tag', 'documents', 'deadline'];
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    // public $timestamps=false;\
    public function assignedtasks()
    {
        return $this->hasMany(AssignedTask::class, 'task_id', 'id');

    }
}
