<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Anime;
use App\Models\Movie;
use App\Models\TVShow;
use Livewire\Component;

class FeaturedToday extends Component
{
    public function render()
    {
        return view('livewire.dashboard.featured-today', [
            'movie' => Movie::todaysFeatured()->first(),
            'tvshow' => TVShow::todaysFeatured()->first(),
            'anime' => Anime::todaysFeatured()->first(),
        ]);
    }
}
