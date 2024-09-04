<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


use App\Models\ApiResourceRequest;
class LogRequestDetails
{
    /**
     * Handle an incoming request.
     *a
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
    
    public function terminate(Request $request, $response): void
    {
        // store sql log errors in logs database table
        
        $startTime = microtime(true);

        $duration = microtime(true)-$startTime;

        $status = $response->status();
        $responseJson = $response->getContent();
        $memoryUsage = number_format(memory_get_usage()  / 1024 / 1024, 2)." MB";

        $controllerAction = optional($request->route())->getActionName();
        $middleware = implode(',', array_keys($request->route()->middleware() ?? []));

        ApiResourceRequest::create([
            'method'=>$request->method(),
            'controller_action'=>$controllerAction,
            'middleware'=>$middleware,
            'path'=>$request->path(),
            'status'=>$status,
            'duration'=>number_format($duration, 4) . ' s',
            'ip_address'=>$request->ip(),
            'request_headers'=>json_encode($request->headers->all()),
            'response_headers'=>json_encode($response->headers->all()),
            'response_json'=>$responseJson,
            'memory_usage'=>$memoryUsage
        ]);   
    }
}
