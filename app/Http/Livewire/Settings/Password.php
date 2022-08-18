<?php

namespace App\Http\Livewire\Settings;

use App\Rules\CurrentPassword;
use Livewire\Component;

class Password extends Component
{
    public $current_password;

    public $password;

    public $password_confirmation;

    protected function rules()
    {
        return [
            'current_password' => [new CurrentPassword, 'string', 'max:60'],
            'password' => ['required', 'string', 'max:60', 'min:6', 'confirmed'],
        ];
    }

    public function render()
    {
        return view('livewire.settings.password');
    }

    public function update()
    {
        $this->validate();

        request()
            ->user()
            ->update(['password' => bcrypt($this->password)]);

        $this->reset();

        $this->redirect(route('settings'));
    }
}
