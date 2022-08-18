<?php

namespace App\Jobs;

use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchMovieData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public $movie)
    {
    }

    public function handle()
    {
        $movie = $this->movie;

        $movieGenres = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/genre/movie/list')
            ->json()['genres'];

        $results = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/search/movie?query='.$movie['title'])
            ->json()['results'];

        $result = collect($results)
            ->filter(fn ($result) => isset($result['release_date'], $movie['year_released']))
            ->filter(fn ($result) => str_contains($result['release_date'], $movie['year_released']))
            ->first();

        $movieGenres = collect($movieGenres)
            ->mapWithKeys(fn ($genre) => [$genre['id'] => $genre['name']]);

        if ($result) {
            $genres = $result['genre_ids']
                ? collect($result['genre_ids'])
                    ->mapWithKeys(fn ($value) => [$value => $movieGenres[$value]])->implode(', ')
                : null;

            Movie::updateOrCreate([
                'tmdb_id' => $result['id'],
            ], [
                'title' => $result['title'],
                'overview' => $result['overview'],
                'release_date' => $result['release_date'],
                'tmdb_poster_path' => $result['poster_path'],
                'genres' => $genres,
                'imdb_id' => $movie['imdb_id'],
                'imdb_rating' => $movie['imdb_rating'],
                'is_approved' => true,
            ]);
        }
    }
}
