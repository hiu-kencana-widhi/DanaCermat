<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. We keep it in a dedicated directory so
    | view compilation is not blocked by stale files in the default path.
    |
    */

    'compiled' => env('VIEW_COMPILED_PATH', (function () {
        $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.'keuangan-app-compiled-views';

        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    })()),

];
