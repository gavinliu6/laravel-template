<?php

use Illuminate\Support\Facades\App;

if (! function_exists('is_production')) {
    /**
     * Determine if the application is in the production environment.
     */
    function is_production(): bool
    {
        return App::isProduction();
    }
}
