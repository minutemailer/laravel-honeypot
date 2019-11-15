<?php

declare(strict_types=1);

namespace Minutemailer\Honeypot\Providers;

use Illuminate\Support\ServiceProvider;
use Minutemailer\Honeypot\Console\MakeMigrationCommand;

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
                MakeMigrationCommand::class,
            ]);
        }
    }
}
