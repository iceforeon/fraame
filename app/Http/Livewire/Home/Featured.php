<?php

namespace App\Http\Livewire\Home;

use App\Models\Movie;
use Livewire\Component;

class Featured extends Component
{
    public function render()
    {
        return view('livewire.home.featured', [
            'items' => Movie::whereNotNull('poster_path')->inRandomOrder()->get()->take(3),
        ]);
    }
}
