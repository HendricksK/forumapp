<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiLoggerController;

class ApiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        $logger = new ApiLoggerController();
        $response = $next($request);
        
        if (env('ENABLE_API_LOGGER', false)) {
            $logger->log($request, $response);
        }

        return $response;

    }
}
