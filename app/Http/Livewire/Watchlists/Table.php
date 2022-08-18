<?php

namespace App\Http\Livewire\Watchlists;

use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $title = '';

    protected $queryString = ['title' => ['except' => '']];

    public function render()
    {
        return view('livewire.watchlists.table', [
            'watchlists' => request()
                ->user()
                ->watchlists()
                ->when(strlen($this->title) > 3, fn ($q) => $q->titleLike($this->title))
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
