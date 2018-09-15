<?php

namespace App\Core;

use Illuminate\Support\Facades\App;

class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{
    /**
     * Generate an absolute URL to the given path.
     *
     * @param  string  $path
     * @param  mixed  $extra
     * @param  bool|null  $secure
     * @return string
     */
    public function to($path, $extra = [], $secure = null)
    {
        // EXTERNAL TODO: Probably there should be a method to generate ->segments() from string
        // if $path starts with slash, remove it for explode
        $explode_path = $path;
        if (starts_with($explode_path, '/')) {
            $explode_path = substr($explode_path, 1);
        }

        // explode $path to URI segments and get first segment
        $segments = explode('/', $explode_path);
        if ($segments[0] === '') {
            unset($segments[0]);
        }
        if (empty($segments)) {
            $first_segment = '/';
        } else {
            $first_segment = $segments[0];
        }

        $prefix = App::getLocalePrefix();
        // if $path is external,
        // or already have lang prefix
        // do not add lang prefix
        if (strpos($path, '://') === false && '/' . $first_segment !== $prefix) {
            $path = $prefix . $path;
        }

        return parent::to($path, $extra, $secure);
    }

    /**
     * Get the URL for the previous request.
     *
     * @return string
     */
    public function previous()
    {
        // TODO: probably this should be updated in request class
        $referrer = $this->request->headers->get('referer');

        // if referrer is main page containing leading slash, remove it
        if ($referrer) {
            $schema = parse_url($referrer);
            if (isset($schema['path']) && $schema['path'] === '/') {
                $referrer = substr($referrer, -1, 1);
                $this->request->headers->set('referer', $referrer);
            }
        }

        return parent::previous();
    }
}
