<?php

namespace App\Http\Livewire\Animes;

use App\Enums\Category;
use App\Jobs\CreatePoster;
use App\Models\Anime;
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

    public Anime $anime;

    protected function rules()
    {
        return [
            'anime.title' => ['required', 'string', 'max:255'],
            'anime.overview' => ['required', 'string'],
            'anime.first_air_date' => ['required', 'date'],
            'anime.genres' => ['required', 'string', 'max:255'],
            'anime.tmdb_id' => ['nullable'],
            'anime.tmdb_poster_path' => ['nullable', 'string'],
            'anime.imdb_id' => ['nullable', 'string'],
            'anime.imdb_rating' => ['nullable', 'string'],
            'anime.is_approved' => ['required', 'in:1,2'],
        ];
    }

    public function mount()
    {
        $this->anime = $this->hashid
            ? Anime::findOr($this->hashid, fn () => abort(404))
            : (new Anime);
    }

    public function render()
    {
        return view('livewire.animes.form');
    }

    public function save()
    {
        $this->validate();

        $this->anime->save();

        $this->redirectRoute('animes.index');
    }

    public function delete()
    {
        Anime::find($this->anime->hashid)->delete();

        $this->redirectRoute('animes.index');
    }

    public function updatedSearch($value)
    {
        $this->results = strlen(trim($value)) > 2 ? $this->searchAnime() : [];
    }

    public function searchAnime()
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
            ->filter(fn ($result) => in_array(16, $result['genre_ids']) && isset($result['first_air_date']))
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

    public function pickAnime($id)
    {
        $anime = Http::retry(3, 300)
            ->withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/tv/'.$id)
            ->json();

        $genres = $anime['genres']
            ? implode(', ', collect($anime['genres'])->pluck('name')->toArray())
            : null;

        $this->anime->title = $anime['name'];
        $this->anime->overview = $anime['overview'];
        $this->anime->first_air_date = $anime['first_air_date'];
        $this->anime->genres = $genres;
        $this->anime->tmdb_id = $anime['id'];
        $this->anime->tmdb_poster_path = $anime['poster_path'];

        $this->clear();
    }

    public function generatePoster()
    {
        CreatePoster::dispatch($this->anime->hashid, Category::Anime);
    }

    public function removePoster()
    {
        Storage::disk('media')->delete($this->anime->poster_path);

        $this->anime->update(['poster_path' => null]);
    }

    public function clear()
    {
        $this->reset(['search', 'results']);
    }
}
