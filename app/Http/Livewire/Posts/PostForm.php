<?php

namespace App\Http\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class PostForm extends Component
{
    public Post $post;

    public $items = [];

    public $results = [];

    public $search;

    protected function rules()
    {
        return [
            'post.title' => ['required', 'string', 'max:100'],
            'post.content' => ['nullable', 'string'],
        ];
    }

    public function mount($hashid = null)
    {
        $this->post = $hashid
            ? request()->user()->posts()->findOr($hashid, fn () => abort(404))
            : (new Post);
    }

    public function render()
    {
        return view('livewire.posts.post-form');
    }

    public function submit()
    {
        $this->validate();

        request()->user()->posts()->save($this->post);

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
                    ? config('services.tmdb.poster_url')."/w200/".$result['poster_path']
                    : config('services.tmdb.no_img_url'),
                'year_released' => Carbon::parse($result['release_date'])->format('Y')
            ])->only(['id', 'poster_path', 'original_title', 'year_released', 'overview']);
        })->take(7);
    }

    public function addItem($value)
    {
        $item = Http::withToken(config('services.tmdb.token'))->get(config('services.tmdb.api_url').'/movie/'.$value)->json();

        $itemCount = count($this->items);

        $this->items[] = [
            'order' =>  $itemCount == 0 ? 1 : $itemCount + 1,
            'id' => $item['id'],
            'original_title' => $item['original_title'],
            'year_released' => Carbon::parse($item['release_date'])->format('Y')
        ];

        $this->reset(['search', 'results']);
    }

    public function sortItems($items)
    {
        $this->items = collect($items)
            ->map(fn ($item) => collect($this->items)->where('id', $item['value'])->first())
            ->toArray();
    }
}
