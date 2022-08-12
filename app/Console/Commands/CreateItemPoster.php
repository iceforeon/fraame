<?php

namespace App\Console\Commands;

use App\Enums\ItemType;
use App\Jobs\CreateItemPoster as CreateItemPosterJob;
use App\Models\Movie;
use App\Models\TvShow;
use Illuminate\Console\Command;

class CreateItemPoster extends Command
{
    protected $signature = 'create:poster {type=movie : movie, tvshow}';

    protected $description = 'Create poster';

    public function handle()
    {
        if ($this->argument('type') == ItemType::Movie->value) {
            Movie::whereNull('poster_path')
                ->each(fn ($movie) => CreateItemPosterJob::dispatch($movie, ItemType::Movie));
        }

        if ($this->argument('type') == ItemType::Movie->value) {
            TvShow::whereNull('poster_path')
                ->each(fn ($tvshow) => CreateItemPosterJob::dispatch($tvshow, ItemType::TVShow));
        }
    }
}
