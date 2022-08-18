<?php

namespace App\Http\Livewire\Movies;

use App\Enums\Category;
use App\Jobs\CreatePoster;
use App\Models\Movie;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    public $hashid;

    public $search;

    public $results = [];

    public Movie $movie;

    protected function rules()
    {
        return [
            'movie.title' => ['required', 'string', 'max:255'],
            'movie.overview' => ['required', 'string'],
            'movie.release_date' => ['required', 'date'],
            'movie.genres' => ['required', 'string', 'max:255'],
            'movie.tmdb_id' => ['nullable'],
            'movie.tmdb_poster_path' => ['nullable', 'string'],
            'movie.imdb_id' => ['nullable', 'string'],
            'movie.imdb_rating' => ['nullable', 'string'],
        ];
    }

    public function mount()
    {
        $this->movie = $this->hashid
            ? Movie::findOr($this->hashid, fn () => abort(404))
            : (new Movie);
    }

    public function render()
    {
        return view('livewire.movies.form');
    }

    public function save()
    {
        $this->validate();

        $this->movie->save();

        $this->redirectRoute('movies.index');
    }

    public function delete()
    {
        Movie::find($this->movie->hashid)->delete();

        $this->redirectRoute('movies.index');
    }

    public function updatedSearch($value)
    {
        $this->results = strlen(trim($value)) > 2 ? $this->searchMovie() : [];
    }

    public function searchMovie()
    {
        if ($this->search == 'iceforeon') {
            return collect([
                [
                    'id' => 'ife133769420',
                    'poster_path' => '/img/ife-poster.png',
                    'original_title' => 'Iceforeon',
                    'year_released' => '1996',
                    'overview' => 'Abandon all hope, ye who enter here.',
                ],
            ]);
        }

        if (Str::contains($this->search, 'tmdbid:')) {
            $id = explode('tmdbid:', $this->search)[1];
            $results[] = Http::retry(3, 300)
                ->withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.api_url').'/movie/'.$id)
                ->json();
        } else {
            $results = Http::retry(3, 300)
                ->withHeaders(['Accept-Language' => 'en-US'])
                ->withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.api_url').'/search/movie?query='.$this->search)
                ->json()['results'];
        }

        return collect($results)
            ->filter(fn ($result) => isset($result['release_date']))
            ->map(function ($result) {
                return collect($result)->merge([
                    'poster_path' => $result['poster_path']
                        ? config('services.tmdb.poster_url').'/w200/'.$result['poster_path']
                        : '/img/no-poster.png',
                    'year_released' => Carbon::parse($result['release_date'])->format('Y'),
                ])->only(['id', 'poster_path', 'title', 'year_released', 'overview']);
            })->take(5);
    }

    public function pickMovie($id)
    {
        if ($id == 'ife133769420') {
            return $this->clear();
        }

        $movie = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/movie/'.$id)
            ->json();

        $genres = $movie['genres']
            ? implode(', ', collect($movie['genres'])->pluck('name')->toArray())
            : null;

        $this->movie->title = $movie['title'];
        $this->movie->overview = $movie['overview'];
        $this->movie->release_date = $movie['release_date'];
        $this->movie->genres = $genres;
        $this->movie->tmdb_id = $movie['id'];
        $this->movie->tmdb_poster_path = $movie['poster_path'];

        $this->clear();
    }

    public function generatePoster()
    {
        CreatePoster::dispatch($this->movie->hashid, Category::Movie);
    }

    public function removePoster()
    {
        Storage::disk('media')->delete($this->movie->poster_path);

        $this->movie->update(['poster_path' => null]);
    }

    public function clear()
    {
        $this->reset(['search', 'results']);
    }
}
