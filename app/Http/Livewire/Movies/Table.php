<?php

namespace App\Http\Livewire\Movies;

use App\Models\Movie;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $title = '';

    protected $queryString = [
        'title' => [
            'except' => '',
        ],
    ];

    public function render()
    {
        return view('livewire.movies.table', [
            'movies' => Movie::query()
                ->when(strlen($this->title) >= 3, fn ($q) => $q->titleLike($this->title))
                ->imdbRating()
                ->paginate(12),
        ]);
    }

    public function updatedTitle($value)
    {
        if (empty($value)) {
            $this->resetPage();
        }
    }
}
