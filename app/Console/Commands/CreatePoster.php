<?php

namespace App\Console\Commands;

use App\Enums\Category;
use App\Jobs\CreatePoster as CreatePosterJob;
use App\Models\Movie;
use App\Models\TvShow;
use Illuminate\Console\Command;

class CreatePoster extends Command
{
    protected $signature = 'create:poster {type=movie : movie, tvshow}';

    protected $description = 'Create poster';

    public function handle()
    {
        if ($this->argument('type') == Category::Movie->value) {
            Movie::whereNull('poster_path')
                ->each(fn ($movie) => CreatePosterJob::dispatch($movie, Category::Movie));
        }

        if ($this->argument('type') == Category::Movie->value) {
            TvShow::whereNull('poster_path')
                ->each(fn ($tvshow) => CreatePosterJob::dispatch($tvshow, Category::TVShow));
        }
    }
}
