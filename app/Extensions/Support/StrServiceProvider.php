<?php

namespace App\Extensions\Support;

use Hidehalo\Nanoid\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class StrServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        'nanoid' => Client::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Str::macro('nanoid', fn () => app('nanoid')->formattedId(
            alphabet: '0123456789abcdefghijklmnopqrstuvwxyz',
            size: 12
        ));

        Str::macro('isNanoid', function ($value): bool {
            if (! is_string($value)) {
                return false;
            }

            if (strlen($value) !== 12) {
                return false;
            }

            return strspn($value, '0123456789abcdefghijklmnopqrstuvwxyz') === 12;
        });

        Stringable::macro('isNanoid', fn () => Str::isNanoid((string) $this));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return ['nanoid'];
    }
}
