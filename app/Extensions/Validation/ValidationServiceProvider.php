<?php

namespace App\Extensions\Validation;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend(
            'nanoid',
            fn ($attribute, $value, $parameters, $validator) => Str::isNanoid($value),
            'The :attribute field is invalid.'
        );
    }
}
