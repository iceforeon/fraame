<?php

namespace App\Http\Livewire\Home;

use App\Enums\ItemType;
use App\Models\Movie;
use App\Models\TvShow;
use Livewire\Component;

class Suggestion extends Component
{
    public $type;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->type = ItemType::Movie->value;
    }

    public function render()
    {
        if ($this->type == ItemType::Movie->value) {
            return view('livewire.home.suggestion', [
                'item' => Movie::hasPoster()
                    ->inRandomOrder()
                    ->first(),
            ]);
        }

        if ($this->type == ItemType::TVShow->value) {
            return view('livewire.home.suggestion', [
                'item' => TvShow::hasPoster()
                    ->inRandomOrder()
                    ->first(),
            ]);
        }
    }

    public function updatedType($value)
    {
        $itemType = ItemType::tryFrom($value);

        if (is_null($itemType)) {
            abort(404);
        }
    }
}
