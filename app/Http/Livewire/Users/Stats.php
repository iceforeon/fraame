<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;

class Stats extends Component
{
    public function render()
    {
        return <<<'blade'
            <a href="{{ route('animes.index') }}" class="px-4 py-5 bg-white shadow-sm hover:shadow-lg focus:shadow-lg rounded-sm overflow-hidden sm:p-6 transition ease-in-out duration-150 focus:outline-none">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                <dd class="mt-1 text-3xl tracking-tight font-semibold text-gray-900">{{ \App\Models\User::count() }}</dd>
            </a>
        blade;
    }
}
