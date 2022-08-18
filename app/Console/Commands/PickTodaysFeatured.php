<?php

namespace App\Console\Commands;

use App\Enums\Category;
use App\Jobs\PickTodaysFeatured as PickTodaysFeaturedJob;
use Illuminate\Console\Command;

class PickTodaysFeatured extends Command
{
    protected $signature = 'pick:featured';

    protected $description = "Pick today's featured";

    public function handle()
    {
        foreach (Category::cases() as $category) {
            PickTodaysFeaturedJob::dispatch($category);
        }
    }
}
