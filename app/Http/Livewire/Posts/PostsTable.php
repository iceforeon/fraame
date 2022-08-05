<?php

namespace App\Http\Livewire\Posts;

use Livewire\Component;
use Livewire\WithPagination;

class PostsTable extends Component
{
    use WithPagination;

    public $title = '';

    protected $queryString = ['title' => ['except' => '']];

    public function render()
    {
        return view('livewire.posts.posts-table', [
            'posts' => request()
                ->user()
                ->posts()
                ->when($this->title > 3, fn ($q) => $q->titleLike($this->title))
                ->paginate(12),
        ]);
    }
}
