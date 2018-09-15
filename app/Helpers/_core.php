<?php

// default Laravel helpers should be overwritten here
// This file is includes in Laravel bootstrap before framework init

// also core functions might be defined here

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;

/**
 * Get the path to a versioned Elixir file.
 *
 * @param  string  $file
 * @return string
 */
function elixir($file)
{
    static $manifest = null;

    if (is_null($manifest)) {
        $manifest = json_decode(file_get_contents(public_path('rev-manifest.json')), true);
    }

    if (isset($manifest[$file])) {
        return '/' . $manifest[$file];
    }

    throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
}

function public_path($path = '')
{
    if (mb_strpos($path, '/') === 0) {
        $path = mb_substr($path, 1);
    }
    return app()->make('path.public').($path ? DIRECTORY_SEPARATOR.$path : $path);
}

function str_blade(string $str, array $args) : string
{
    $parser = new \App\Helpers\BladeParser();
    return $parser->parse($str, $args);
}

function get_build_number()
{
    $file = base_path('build_number.txt');
    if (file_exists($file)) {
        return file_get_contents(base_path('build_number.txt'));
    } else {
        return 'NULL';
    }
}

function route_url($route)
{
    return url('/' . trans('routes.' . $route));
}

function trans_url($locale = null)
{
    if ($locale === null) {
        $locale = config('app.fallback_locale');
    }

    $route_langs = Lang::get('routes');
    $detected_route = '';
    foreach ($route_langs as $route => $route_lang) {
        if (strpos(Request::getPathInfo(), $route_lang) !== false) {
            $detected_route = $route;
            break;
        }
    }

    $new_route_langs = Lang::get('routes', [], $locale);
    if ($detected_route !== '') {
        return App::getLocalePrefix($locale) . '/' . $new_route_langs[$detected_route];
    } else {
        $segments = Request::segments();
        if (isset($segments[0]) && '/' . $segments[0] === App::getLocalePrefix()) {
            // if first segment already is locale prefix, remove it
            // to build new url with implode()
            unset($segments[0]);
        }

        if (empty($segments)) {
            // index page
            if (App::getLocalePrefix($locale) === '') {
                // return root slash because locale prefix is empty for default locale
                return '/';
            } else {
                return  App::getLocalePrefix($locale);
            }
        } else {
            // return new URL build from segments, replacing 1st segment by locale prefix if required
            return  App::getLocalePrefix($locale) . '/' . implode('/', $segments);
        }
    }
}

/**
 * Get the path to the dump folder.
 *
 * @param  string  $path
 * @return string
 */
function dump_path($path = '')
{
    return app()->basePath().DIRECTORY_SEPARATOR.'database/dumps'.($path ? DIRECTORY_SEPARATOR.$path : $path);
}

function flash($lang_id, $params = [], $type = APP_FLASH_SUCCESS)
{
    if (!Lang::has($lang_id)) {
        throw new Exception('flash(): Lang string "'.$lang_id.'" does not exists.');
    }

    Session::flash('alert', $lang_id);
    Session::flash('alert_params', $params);

    $flash_types = [
        APP_FLASH_SUCCESS => 'success',
        APP_FLASH_ERROR   => 'error',
    ];

    Session::flash('alert_type', $flash_types[$type]);
}
