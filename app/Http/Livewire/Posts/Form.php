<?php

namespace App\Http\Livewire\Posts;

use App\Enums\Category;
use App\Models\Post;
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
            $this->hashid && $post = request()->user()->posts()->findOr($this->hashid, fn () => abort(404))
        ) {
            $this->hashid = $post->hashid;
            $this->items = $post->items;
            $this->title = $post->title;
            $this->description = $post->description;
        }

        $this->category = Category::Movie->value;
    }

    public function render()
    {
        return view('livewire.posts.form');
    }

    public function save()
    {
        $this->validate();

        Post::updateOrCreate([
            'hashid' => $this->hashid,
            'user_id' => request()->user()->id,
        ], [
            'items' => $this->items,
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $this->redirectRoute('posts.index');
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

        $category = $this->category == Category::Movie->value ? 'movie' : 'tv';

        $results = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url')."/search/{$category}?query=".$this->search)
            ->json()['results'];

        return collect($results)
            ->filter(fn ($result) => isset($result['release_date']) || isset($result['first_air_date']))
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
            $this->hashid && $post = request()->user()->posts()->findOr($this->hashid, fn () => abort(404))
        ) {
            $post->delete();
        }

        $this->redirectRoute('posts.index');
    }
}
