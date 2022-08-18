<?php

namespace App\Http\Livewire\Home;

use App\Models\Movie;
use Livewire\Component;

class Featured extends Component
{
    public function render()
    {
        // select title, tmdb_poster_path, year_released
        // join movies, tvshows, animes

        return view('livewire.home.featured', [
            'items' => Movie::query()
                ->todaysFeatured()
                ->inRandomOrder()
                ->get()
                ->take(3),
        ]);
    }
}
