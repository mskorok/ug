<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BuildGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates git build number.';

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
        $cmd = exec("git tag -n");
        $res = preg_split('/\s+/', $cmd);

        $tag_name = $res[0];
        $tag_description = $res[1];
        $commit_count = exec("git rev-list $tag_name..HEAD --count");

        $version = $tag_name . '.' . $commit_count . ' (' . $tag_description .')';

        if (file_put_contents('build_number.txt', $version)) {
            $this->info('build_number.txt created with build version: '.$version);
        } else {
            $this->error('ERROR: Unable to create or edit file build_info.txt');
        }
    }
}
