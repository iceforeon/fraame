<?php

namespace App\Jobs;

use App\Enums\Category;
use App\Models\Movie;
use App\Models\TvShow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PickTodaysFeatured implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Category $category)
    {
    }

    public function handle()
    {
        if ($this->category == Category::Movie) {
            $movie = Movie::query()
                ->approved()
                ->whereNull('featured_at')
                ->orWhereDate('featured_at', '<=', now()->subMonth(1)->startOfDay())
                ->inRandomOrder()
                ->get()
                ->take(1);

            if ($movie) {
                $movie->update(['featured_at' => now()]);
                \Log::info("$movie->title"); // log to featured-movies.log
            }
        }

        if ($this->category == Category::TVShow) {
            $tvshow = TvShow::query()
                ->approved()
                ->whereNull('featured_at')
                ->orWhereDate('featured_at', '<=', now()->subMonth(1)->startOfDay())
                ->inRandomOrder()
                ->get()
                ->take(1);

            if ($tvshow) {
                $tvshow->update(['featured_at' => now()]);
                \Log::info("$tvshow->title"); // log to featured-tvshows.log
            }
        }

        if ($this->category == Category::Anime) {
            $anime = Anime::query()
                ->approved()
                ->whereNull('featured_at')
                ->orWhereDate('featured_at', '<=', now()->subMonth(1)->startOfDay())
                ->inRandomOrder()
                ->get()
                ->take(1);

            if ($anime) {
                $anime->update(['featured_at' => now()]);
                \Log::info("$anime->title"); // log to featured-tvshows.log
            }
        }
    }
}
