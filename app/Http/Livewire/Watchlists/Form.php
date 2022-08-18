<?php

namespace App\Http\Livewire\Watchlists;

use App\Enums\Category;
use App\Models\Watchlist;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Form extends Component
{
    public $hashid;

    public $search;

    public $category;

    public $results = [];

    public $items = [];

    public $title;

    public $description;

    protected function rules()
    {
        return [
            'items' => ['nullable', 'array'],
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function mount()
    {
        if (
            $this->hashid && $watchlist = request()->user()->watchlists()->findOr($this->hashid, fn () => abort(404))
        ) {
            $this->hashid = $watchlist->hashid;
            $this->items = $watchlist->items;
            $this->title = $watchlist->title;
            $this->description = $watchlist->description;
        }

        $this->category = Category::Movie->value;
    }

    public function render()
    {
        return view('livewire.watchlists.form');
    }

    public function save()
    {
        $this->validate();

        Watchlist::updateOrCreate([
            'hashid' => $this->hashid,
            'user_id' => request()->user()->id,
        ], [
            'items' => $this->items,
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $this->redirectRoute('watchlists.index');
    }

    public function updatedSearch($value)
    {
        $this->results = strlen(trim($value)) > 3 ? $this->itemSearch() : [];
    }

    public function updatedCategory()
    {
        $this->clear();
    }

    public function itemSearch()
    {
        $category = $this->category == Category::Movie->value ? 'movie' : 'tv';

        $results = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url')."/search/{$category}?query=".$this->search)
            ->json()['results'];

        return collect($results)
            ->when($this->category == Category::Anime->value, function ($results) {
                return $results->filter(fn ($result) => in_array(16, $result['genre_ids']));
            })
            ->filter(function ($result) {
                return isset($result['release_date']) || isset($result['first_air_date']);
            })
            ->map(function ($result) {
                return collect($result)->merge([
                    'title' => $this->category == Category::Movie->value
                        ? $result['title']
                        : $result['name'],
                    'poster_path' => $result['poster_path']
                        ? config('services.tmdb.poster_url').'/w200/'.$result['poster_path']
                        : '/img/no-poster.png',
                    'year_released' => Carbon::parse(
                        $this->category == Category::Movie->value
                            ? $result['release_date']
                            : $result['first_air_date']
                    )->format('Y'),
                ])->only(['id', 'poster_path', 'title', 'year_released', 'overview']);
            })->take(5);
    }

    public function addItem($id)
    {
        if ($id == 'ife133769420') {
            return $this->clear();
        }

        $category = $this->category == Category::Movie->value
            ? 'movie'
            : 'tv';

        $item = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url')."/{$category}/".$id)
            ->json();

        $this->items[] = [
            'order' => count($this->items) + 1,
            'id' => $item['id'],
            'title' => $this->category == Category::Movie->value
                ? $item['title']
                : $item['name'],
            'year_released' => Carbon::parse(
                $this->category == Category::Movie->value
                    ? $item['release_date']
                    : $item['first_air_date']
            )->format('Y'),
        ];

        $this->clear();
    }

    public function removeItem($id)
    {
        $this->items = collect($this->items)
            ->filter(fn ($item) => $item['id'] !== (int) $id)
            ->toArray();
    }

    public function sortItems($items)
    {
        $this->items = collect($items)
            ->map(fn ($item) => collect($this->items)->where('id', $item['value'])->first());
    }

    public function clear()
    {
        $this->reset(['search', 'results']);
    }

    public function delete()
    {
        if (
            $this->hashid && $watchlist = request()->user()->watchlists()->where('hashid', $this->hashid)
        ) {
            $watchlist->delete();
        }

        $this->redirectRoute('watchlists.index');
    }
}
