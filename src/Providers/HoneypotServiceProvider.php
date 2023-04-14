<?php

declare(strict_types=1);

namespace Minutemailer\Honeypot\Providers;

use Illuminate\Support\ServiceProvider;
use Minutemailer\Honeypot\Console\MakeMigrationCommand;

class HoneypotServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeMigrationCommand::class,
            ]);
        }
    }
}
