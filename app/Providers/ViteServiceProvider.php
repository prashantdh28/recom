<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Vite;

class ViteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Vite::class, function ($app) {
            return new class($app['config']['vite']) extends Vite {
                // ⛏️ FIX: Use public here instead of protected
                public function isRunningHot(): bool
                {
                    return false;
                }
            };
        });
    }
}

