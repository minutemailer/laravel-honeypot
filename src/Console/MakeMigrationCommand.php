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
     * Copy the migration stub for creating credit_buckets-table
     */
    private function makeBucketMigration()
    {
        $dateTime = date('Y_m_d_Hi01');
        $fileName = base_path('database/migrations/' . $dateTime . '_create_credit_buckets_table.php');

        copy(__DIR__ . '/stubs/create_credit_buckets_table.stub', $fileName);
    }

    /**
     * Copy the migration stub for creating types-table
     */
    private function makeTypesMigration()
    {
        $dateTime = date('Y_m_d_Hi00');
        $fileName = base_path('database/migrations/' . $dateTime . '_create_credit_types_table.php');

        copy(__DIR__ . '/stubs/create_credit_types_table.stub', $fileName);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->makeTypesMigration();
        $this->makeBucketMigration();
    }
}
