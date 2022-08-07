<?php

namespace App\Http\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class PostForm extends Component
{
    public $hashid;

    public $search;

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
    }

    public function render()
    {
        return view('livewire.posts.post-form');
    }

    public function submit()
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
        $this->results = strlen($value) > 3 ? $this->itemSearch() : [];
    }

    public function itemSearch()
    {
        $results = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.api_url').'/search/movie?query='.$this->search)->json()['results'];

        return collect($results)->map(function ($result) {
            return collect($result)->merge([
                'poster_path' => $result['poster_path']
                    ? config('services.tmdb.poster_url').'/w200/'.$result['poster_path']
                    : config('services.tmdb.no_img_url'),
                'year_released' => Carbon::parse($result['release_date'])->format('Y'),
            ])->only(['id', 'poster_path', 'original_title', 'year_released', 'overview']);
        })->take(5);
    }

    public function addItem($value)
    {
        $item = Http::withToken(config('services.tmdb.token'))->get(config('services.tmdb.api_url').'/movie/'.$value)->json();

        $this->items[] = [
            'order' => count($this->items) + 1,
            'id' => $item['id'],
            'original_title' => $item['original_title'],
            'year_released' => Carbon::parse($item['release_date'])->format('Y'),
        ];

        $this->clear();
    }

    public function removeItem($id)
    {
        $this->items = collect($this->items)
            ->filter(fn ($item) => $item['id'] !== $id)
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
