<?php

namespace App\Console\Commands;

use App\Enums\Category;
use App\Jobs\CreatePoster as CreatePosterJob;
use App\Models\Anime;
use App\Models\Movie;
use App\Models\TVShow;
use Illuminate\Console\Command;

class CreatePoster extends Command
{
    protected $signature = 'create:poster';

    protected $description = 'Create poster';

    public function handle()
    {
        Movie::whereNull('poster_path')
            ->each(fn ($movie) => CreatePosterJob::dispatch($movie, Category::Movie));

        TVShow::whereNull('poster_path')
            ->each(fn ($tvshow) => CreatePosterJob::dispatch($tvshow, Category::TVShow));

        Anime::whereNull('poster_path')
            ->each(fn ($anime) => CreatePosterJob::dispatch($anime, Category::Anime));
    }
}
