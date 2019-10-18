<?php

namespace Minutemailer\Honeypot\Console;

use Illuminate\Console\Command;

class MakeMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'honeypot:migration:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic migrations for honeypot';

    /**
     * Copy the migration stub for creating credit_buckets-table.
     *
     * @return mixed
     */
    public function handle()
    {
        $dateTime = date('Y_m_d_His');
        $fileName = base_path('database/migrations/' . $dateTime . '_create_credit_buckets_table.php');

        copy(__DIR__ . '/stubs/create_credit_buckets_table.stub', $fileName);
        $this->line(\sprintf('Migration %s file created', $fileName));
    }
}
