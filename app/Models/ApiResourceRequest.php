<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiResourceRequest extends Model
{
    use HasFactory;
    
    protected $table = 'api_resources_request';
    protected $fillable = [
        'method',
        'controller_action',
        'middleware',
        'path',
        'status',
        'duration',
        'ip_address',
        'request_headers',
        'response_headers',
        'response_json',
        'memory_usage'
    ];
}
