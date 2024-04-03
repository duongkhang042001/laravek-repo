<?php

use App\Core;

if (!function_exists('core')) {
    function core()
    {
        return app()->make(Core::class);
    }
}
