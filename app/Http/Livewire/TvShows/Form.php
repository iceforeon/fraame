<?php

namespace App\Http\Livewire\TvShows;

use App\Enums\Category;
use App\Models\TVShow;
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

    public TvShow $tvshow;

    protected function rules()
    {
        return [
            'tvshow.title' => ['required', 'string', 'max:255'],
            'tvshow.overview' => ['required', 'string'],
            'tvshow.first_air_date' => ['required', 'date'],
            'tvshow.genres' => ['required', 'string', 'max:255'],
            'tvshow.tmdb_id' => ['nullable'],
            'tvshow.tmdb_poster_path' => ['nullable', 'string'],
            'tvshow.imdb_id' => ['nullable', 'string'],
            'tvshow.imdb_rating' => ['nullable', 'string'],
            'tvshow.is_approved' => ['required', 'in:1,2'],
        ];
    }

    public function mount()
    {
        $this->tvshow = $this->hashid
            ? TVShow::findOr($this->hashid, fn () => abort(404))
            : (new TvShow);
    }

    public function render()
    {
        return view('livewire.tv-shows.form');
    }

    public function save()
    {
        $this->validate();

        $this->tvshow->save();

        $this->redirectRoute('tv-shows.index');
    }

    public function delete()
    {
        TVShow::find($this->tvshow->hashid)->delete();

        $this->redirectRoute('tv-shows.index');
    }

    public function updatedSearch($value)
    {
        $this->results = strlen(trim($value)) > 2 ? $this->searchTvShow() : [];
    }

    public function searchTvShow()
    {
        if (Str::contains($this->search, 'tmdbid:')) {
            $id = explode('tmdbid:', $this->search)[1];
            $results[] = Http::retry(3, 300)
                ->withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.api_url').'/tv/'.$id)
                ->json();
        } else {
            $results = Http::retry(3, 300)
                ->withHeaders(['Accept-Language' => 'en-US'])
                ->withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.api_url').'/search/tv?query='.$this->search)
                ->json()['results'];
        }

        return collect($results)
            ->filter(fn ($result) => isset($result['first_air_date']))
            ->map(function ($result) {
                return collect($result)->merge([
                    'title' => $result['name'],
                    'poster_path' => $result['poster_path']
                        ? config('services.tmdb.poster_url').'/w200/'.$result['poster_path']
                        : '/img/no-poster.png',
                    'year_released' => Carbon::parse($result['first_air_date'])->format('Y'),
                ])->only(['id', 'poster_path', 'title', 'year_released', 'overview']);
            })->take(5);
    }

    public function pickTvShow($id)
    {
        $tvshow = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/tv/'.$id)
            ->json();

        $genres = $tvshow['genres']
            ? implode(', ', collect($tvshow['genres'])->pluck('name')->toArray())
            : null;

        $this->tvshow->title = $tvshow['name'];
        $this->tvshow->overview = $tvshow['overview'];
        $this->tvshow->first_air_date = $tvshow['first_air_date'];
        $this->tvshow->genres = $genres;
        $this->tvshow->tmdb_id = $tvshow['id'];
        $this->tvshow->tmdb_poster_path = $tvshow['poster_path'];

        $this->clear();
    }

    public function generatePoster()
    {
        CreatePoster::dispatch($this->tvshow->hashid, Category::TVShow);
    }

    public function removePoster()
    {
        Storage::disk('media')->delete($this->tvshow->poster_path);

        $this->tvshow->update(['poster_path' => null]);
    }

    public function clear()
    {
        $this->reset(['search', 'results']);
    }
}
