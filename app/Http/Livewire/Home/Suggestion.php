<?php

namespace App\Http\Livewire\Home;

use App\Enums\Category;
use App\Models\Movie;
use App\Models\TvShow;
use Livewire\Component;

class Suggestion extends Component
{
    public $category;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->category = Category::Movie->value;
    }

    public function render()
    {
        if ($this->category == Category::Movie->value) {
            return view('livewire.home.suggestion', [
                'item' => Movie::hasPoster()
                    ->inRandomOrder()
                    ->first(),
            ]);
        }

        if ($this->category == Category::TVShow->value) {
            return view('livewire.home.suggestion', [
                'item' => TvShow::hasPoster()
                    ->inRandomOrder()
                    ->first(),
            ]);
        }
    }

    public function updatedType($value)
    {
        if (is_null(Category::tryFrom($value))) {
            abort(404);
        }
    }
}
