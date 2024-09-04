<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Requests\EditTaskRequest;
use Illuminate\Support\Facades\Auth;

class checkTaskPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $taskId = $request->id;
        $user = Auth::user();
        if($user->assignedtasks()->where('task_id', $taskId)->exists()){
            return $user->hasPermissionTo('update assigned task') ??  $next($request);

        }
        return sendForbiddenResponse();
    }
}
