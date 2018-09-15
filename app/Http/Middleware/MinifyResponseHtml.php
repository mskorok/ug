<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

/**
 * Class MinifyResponseHtml
 * @package App\Http\Middleware
 */
class MinifyResponseHtml
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $response = $next($request);
        if ($response instanceof Response) {
            $output = $response->getContent();
            $output = preg_replace('/<!--([^\[|(<!)].*)/', '', $output);
            $output = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $output);

            // Clean Whitespace
            // I've commented this line because it was cuting some html
            $output = preg_replace('/\s{3,}/', '', $output);
            $output = preg_replace('/(\r?\n)/', '', $output);
            $response->setContent($output);
        }

        return $response;
    }
}
