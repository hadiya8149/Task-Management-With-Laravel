<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class Task extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = ['title', 'description', 'status', 'tag', 'documents', 'deadline'];
    protected $table = 'tasks';
    // public $timestamps=false;\
    public function assignedtasks()
    {
        return $this->hasMany(AssignedTask::class);

    }
}
