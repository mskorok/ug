<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DbRebuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hard drop all tables and run all migrations and seeds from beginning.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pdo = DB::connection()->getPdo();
        $pdo->query('SET foreign_key_checks = 0');
        $result = $pdo->query('SHOW TABLES');
        foreach ($result as $row) {
            $pdo->query('DROP TABLE IF EXISTS '.$row[0]);
            $this->info('Dropped table: '.$row[0]);
        }
        $pdo->query('SET foreign_key_checks = 1');

        //Artisan::call('migrate');
        //Artisan::call('db:seed');
    }
}
