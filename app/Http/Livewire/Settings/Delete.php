<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Delete extends Component
{
    public $username;

    public function render()
    {
        return view('livewire.settings.delete');
    }

    public function delete()
    {
        $user = request()->user();

        if ($this->username !== $user->username) {
            return $this->addError('username', 'Invalid username.');
        }

        request()->user()->delete();

        return redirect(route('login'));
    }
}
