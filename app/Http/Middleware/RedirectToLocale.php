<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class RedirectToLocale
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
        if (App::getLocalePrefix() === '') {
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) !== false) {
                // if user was redirected from app itself, do not change locale and redirect him again
                // for example, user changed language from menu and was already redirected by this middleware
            } else {
                // if user logged in, redirect to locale from user account settings
                if (Auth::guard($guard)->check() && Auth::user()->profile_locale !== config('app.fallback_locale')) {
                    return redirect(trans_url(Auth::user()->profile_locale));
                } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                    // if not logged in, check browser's preffered language
                    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                    if (in_array($lang, config('app.additional_locales'))) {
                        return redirect(trans_url($lang));
                    }
                }
            }
        }

        return $next($request);
    }
}
