<?php

namespace App\Jobs;

use App\Models\Anime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchAnimeData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public $anime)
    {
    }

    public function handle()
    {
        $anime = $this->anime;

        $animeGenres = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/genre/tv/list')
            ->json()['genres'];

        $results = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/search/tv?query='.$anime['title'])
            ->json()['results'];

        info($anime['year_released']);

        $result = collect($results)
            ->filter(fn ($result) => in_array(16, $result['genre_ids']))
            ->filter(fn ($result) => isset($result['first_air_date'], $anime['year_released']))
            ->filter(fn ($result) => str_contains($result['first_air_date'], (string) $anime['year_released']))
            ->first();

        info($result);

        $animeGenres = collect($animeGenres)
            ->mapWithKeys(fn ($genre) => [$genre['id'] => $genre['name']]);

        if ($result) {
            $genres = $result['genre_ids']
                ? collect($result['genre_ids'])
                    ->mapWithKeys(fn ($value) => [$value => $animeGenres[$value]])->implode(', ')
                : null;

            Anime::updateOrCreate([
                'tmdb_id' => $result['id'],
            ], [
                'title' => $result['name'],
                'overview' => $result['overview'],
                'first_air_date' => $result['first_air_date'],
                'tmdb_poster_path' => $result['poster_path'],
                'genres' => $genres,
                'imdb_id' => $anime['imdb_id'],
                'imdb_rating' => $anime['imdb_rating'],
                'is_approved' => true,
            ]);
        }
    }
}
