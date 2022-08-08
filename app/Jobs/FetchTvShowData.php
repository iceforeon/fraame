<?php

namespace App\Jobs;

use App\Enums\ItemType;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchTvShowData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function handle()
    {
        $item = $this->item;

        $tvShowGenres = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/genre/tv/list')
            ->json()['genres'];

        $results = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/search/tv?query='.$item['title'])
            ->json()['results'];

        $tvshow = collect($results)->filter(function ($result) use ($item) {
            return isset($result['first_air_date'], $item['year_released'])
                ? str_contains($result['first_air_date'], $item['year_released'])
                : false;
        })->first();

        $tvShowGenres = collect($tvShowGenres)
            ->mapWithKeys(fn ($genre) => [$genre['id'] => $genre['name']]);

        $genres = collect($tvshow['genre_ids'])
            ->mapWithKeys(fn ($value) => [$value => $tvShowGenres[$value]])->implode(', ');

        if ($tvshow) {
            Item::updateOrCreate([
                'type' => ItemType::TVShow,
                'tmdb_id' => $tvshow['id'],
            ], [
                'title' => $tvshow['name'],
                'overview' => $tvshow['overview'],
                'release_date' => $tvshow['first_air_date'],
                'poster_path' => $tvshow['poster_path'],
                'genres' => $genres,
                'imdb_id' => $item['imdb_id'],
                'imdb_rank' => $item['imdb_rank'],
                'imdb_rating' => $item['imdb_rating'],
            ]);
        }
    }
}
