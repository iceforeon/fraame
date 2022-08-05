<?php

namespace App\Http\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;

class PostForm extends Component
{
    public Post $post;

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
}
