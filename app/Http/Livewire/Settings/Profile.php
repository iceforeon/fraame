<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Profile extends Component
{
    public $name;

    public $username;

    public $description;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'username' => ['required', 'string', 'max:25', 'alpha_num'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function mount()
    {
        $this->name = request()->user()->name;
        $this->username = request()->user()->username;
        $this->description = request()->user()->description;
    }

    public function render()
    {
        return view('livewire.settings.profile');
    }

    public function update()
    {
        $this->validate();

        request()->user()->update([
            'name' => $this->name,
            'username' => $this->username,
            'description' => $this->description,
        ]);
    }
}
