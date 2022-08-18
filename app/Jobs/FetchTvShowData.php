<?php

namespace App\Jobs;

use App\Models\TvShow;
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

    public function __construct(public $tvshow)
    {
    }

    public function handle()
    {
        $tvshow = $this->tvshow;

        $tvShowGenres = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/genre/tv/list')
            ->json()['genres'];

        $results = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/search/tv?query='.$tvshow['title'])
            ->json()['results'];

        $result = collect($results)
            ->filter(fn ($result) => isset($result['first_air_date'], $tvshow['year_released']))
            ->filter(fn ($result) => str_contains($result['first_air_date'], $tvshow['year_released']))
            ->first();

        $tvShowGenres = collect($tvShowGenres)
            ->mapWithKeys(fn ($genre) => [$genre['id'] => $genre['name']]);

        if ($result) {
            $genres = $result['genre_ids']
                ? collect($result['genre_ids'])
                    ->mapWithKeys(fn ($value) => [$value => $tvShowGenres[$value]])->implode(', ')
                : null;

            TvShow::updateOrCreate([
                'tmdb_id' => $result['id'],
            ], [
                'title' => $result['name'],
                'overview' => $result['overview'],
                'first_air_date' => $result['first_air_date'],
                'tmdb_poster_path' => $result['poster_path'],
                'genres' => $genres,
                'imdb_id' => $tvshow['imdb_id'],
                'imdb_rating' => $tvshow['imdb_rating'],
                'is_approved' => true,
            ]);
        }
    }
}
