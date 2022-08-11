<?php

namespace App\Http\Livewire\Movies;

use Livewire\Component;

class Stats extends Component
{
    public function render()
    {
        return <<<'blade'
            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow-sm rounded-sm overflow-hidden">
                <dt>
                    <p class="text-sm font-medium text-gray-500 truncate">Total Movies</p>
                </dt>
                <dd class="pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Movie::count() }}</p>
                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('movies.index') }}" class="font-medium text-gray-600 hover:text-gray-500"> View all<span class="sr-only"> Total Subscribers stats</span></a>
                        </div>
                    </div>
                </dd>
            </div>
        blade;
    }
}
