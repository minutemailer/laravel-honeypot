<?php

namespace Minutemailer\Honeypot\Providers;

use Illuminate\Support\ServiceProvider;

class HoneypotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Minutemailer\Honeypot\Console\MakeMigrationCommand::class,
            ]);
        }
    }
}
