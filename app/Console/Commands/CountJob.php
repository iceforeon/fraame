<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CountJob extends Command
{
    protected $signature = 'count:job {type=default}';

    protected $description = 'Count Job';

    public function handle()
    {
        if ($this->argument('type') == 'default') {
            $this->info(DB::table('jobs')->count());
        }

        if ($this->argument('type') == 'failed') {
            $this->info(DB::table('failed_jobs')->count());
        }
    }
}
