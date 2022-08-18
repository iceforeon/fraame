<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $name = '';

    protected $queryString = ['name' => ['except' => '']];

    public function render()
    {
        return view('livewire.users.table', [
            'users' => User::query()
                ->notMe()
                ->notDev()
                ->latest()
                ->paginate(12),
        ]);
    }

    public function updatedName($value)
    {
        if (empty($value)) {
            $this->resetPage();
        }
    }
}
