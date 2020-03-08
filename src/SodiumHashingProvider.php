<?php

namespace SodiumHashing;

use Illuminate\Hashing\HashManager;
use Illuminate\Support\ServiceProvider;
use SodiumHashing\Manager\SodiumHashManager;

class SodiumHashingProvider extends ServiceProvider
{
    protected const CONFIG = __DIR__ . '../config/sodium_hashing.php';

    public function register(): void
    {
        $this->mergeConfigFrom(
            self::CONFIG,
            'sodium_hashing'
        );

        $this->app->extend('hash', function (HashManager $manager, $app) {
            return new SodiumHashManager($manager, $app);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            self::CONFIG => config_path('sodium_hashing.php'),
        ]);
    }
}
