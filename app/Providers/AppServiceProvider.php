<?php

namespace App\Providers;

use App\Modules\Exceptions\Enums\ErrorCodeEnum;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->defineMacros();
    }

    /**
     * Add any convenience methods to Laravel's built-in services by taking advantage of the "macro" feature.
     */
    private function defineMacros(): void
    {
        Response::macro(
            'success',
            fn (
                $data = [],
                int $status = 200,
                array $headers = []
            ) => response()->json([
                'code' => ErrorCodeEnum::SUCCESS->value,
                'data' => $data,
                'msg' => 'success',
            ], $status, $headers)
        );

        Response::macro(
            'error',
            fn (
                ErrorCodeEnum $code,
                string $msg,
                int $status = 200,
                array $headers = []
            ) => response()->json([
                'code' => $code->value,
                'msg' => $msg,
            ], $status, $headers)
        );
    }
}
