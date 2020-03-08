<?php

namespace SodiumHashing;

use Illuminate\Hashing\HashManager;
use Illuminate\Support\ServiceProvider;
use SodiumHashing\Manager\SodiumHashManager;

class SodiumHashingProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->extend('hash', function (HashManager $manager, $app) {
            return new SodiumHashManager($manager, $app);
        });
    }
}
