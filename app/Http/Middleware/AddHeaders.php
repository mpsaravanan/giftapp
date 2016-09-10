<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

// If Laravel >= 5.2 then delete 'use' and 'implements' of deprecated Middleware interface.
class AddHeaders implements Middleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('X-Frame-Options', 'SAMEORIGIN' );
        $response->header('X-XSS-Protection', '1; mode=block'); // Anti cross site scripting (XSS)
        $response->header('X-Content-Type-Options', 'nosniff'); // Reduce exposure to drive-by dl attacks
        return $response;
    }
}