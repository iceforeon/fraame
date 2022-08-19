<?php

namespace App\Jobs;

use App\Enums\Category;
use App\Models\Anime;
use App\Models\Movie;
use App\Models\TVShow;
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
                ->first();

            if ($movie) {
                info("Movie feature: {$movie->title}");
                $movie->update(['featured_at' => now()->startOfDay()]);
            }
        }

        if ($this->category == Category::TVShow) {
            $tvshow = TVShow::query()
                ->approved()
                ->whereNull('featured_at')
                ->orWhereDate('featured_at', '<=', now()->subMonth(1)->startOfDay())
                ->inRandomOrder()
                ->get()
                ->first();

            if ($tvshow) {
                info("TV Show feature: {$tvshow->title}");
                $tvshow->update(['featured_at' => now()->startOfDay()]);
            }
        }

        if ($this->category == Category::Anime) {
            $anime = Anime::query()
                ->approved()
                ->whereNull('featured_at')
                ->orWhereDate('featured_at', '<=', now()->subMonth(1)->startOfDay())
                ->inRandomOrder()
                ->get()
                ->first();

            if ($anime) {
                info("Anime feature: {$anime->title}");
                $anime->update(['featured_at' => now()->startOfDay()]);
            }
        }
    }
}
