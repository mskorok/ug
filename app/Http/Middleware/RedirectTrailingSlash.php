<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class RedirectTrailingSlash
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uri = $request->getRequestUri();
        if ($uri !== '/' && ends_with($uri, '/')) {
            return redirect(substr($uri, 0, -1), 301);
        }

        return $next($request);
    }
}
