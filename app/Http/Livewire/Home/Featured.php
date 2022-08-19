<?php

namespace App\Http\Livewire\Home;

use App\Models\Anime;
use App\Models\Movie;
use App\Models\TVShow;
use Livewire\Component;

class Featured extends Component
{
    public function render()
    {
        return view('livewire.home.featured', [
            'movie' => Movie::todaysFeatured()->first(),
            'tvshow' => TVShow::todaysFeatured()->first(),
            'anime' => Anime::todaysFeatured()->first(),
        ]);
    }
}
