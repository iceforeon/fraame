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
            'movie' => Movie::query()->todaysFeatured()->first(),
            'tvshow' => TVShow::query()->todaysFeatured()->first(),
            'anime' => Anime::query()->todaysFeatured()->first(),
        ]);
    }
}
