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

class FetchMovieData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function handle()
    {
        // the boat = das boots
        // the hunt = jagten

        $item = $this->item;

        $results = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/search/movie?query='.$item['title'])
            ->json()['results'];

        $movie = collect($results)->filter(function ($result) use ($item) {
            return isset($result['release_date'], $item['year_released'])
                ? str_contains($result['release_date'], $item['year_released'])
                : false;
        })->first();

        if ($movie) {
            Item::updateOrCreate([
                'type' => ItemType::Movie,
                'tmdb_id' => $movie['id'],
            ], [
                'title' => $movie['title'],
                'overview' => $movie['overview'],
                'release_date' => $movie['release_date'],
                'poster_path' => $movie['poster_path'],
                'imdb_id' => $item['imdb_id'],
                'imdb_rank' => $item['imdb_rank'],
                'imdb_rating' => $item['imdb_rating'],
            ]);
        }
    }
}
