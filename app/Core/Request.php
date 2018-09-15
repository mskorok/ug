<?php

namespace App\Core;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Request extends \Illuminate\Http\Request
{
    /**
     * Determine if the current request URI matches a pattern.
     *
     * @param  mixed  string
     * @return bool
     */
    public function is()
    {
        foreach (func_get_args() as $pattern) {
            $prefix = App::getLocalePrefix();
            if ($prefix !== '' && $pattern === '/') {
                $pattern = $prefix;
            } else {
                $pattern = $prefix . $pattern;
            }
            if (Str::is($pattern, urldecode($this->getPathInfo()))) {
                return true;
            }
        }

        return false;
    }
}
