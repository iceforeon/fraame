<?php

namespace App\Console\Commands;

use App\Jobs\CreateItemPoster as CreateItemPosterJob;
use App\Models\Item;
use Illuminate\Console\Command;

class CreateItemPoster extends Command
{
    protected $signature = 'create:poster {hashid}';

    protected $description = 'Create poster';

    public function handle()
    {
        CreateItemPosterJob::dispatch(
            Item::find($this->argument('hashid'))
        );
    }
}
