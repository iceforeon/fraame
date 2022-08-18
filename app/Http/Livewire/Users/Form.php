<?php

namespace App\Http\Livewire\Users;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class Form extends Component
{
    public $hashid;

    public User $user;

    protected function rules()
    {
        return [
            'user.name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'user.username' => ['required', 'string', 'min:3', 'max:25', 'alpha_num', 'unique:users,username,'.$this->user->id],
            'user.email' => ['nullable', 'email', 'unique:users,email,'.$this->user->id],
            'user.description' => ['nullable', 'string', 'max:255'],
            'user.password' => ['sometimes', 'string', 'max:60', 'min:6'],
            'user.role' => ['required', new Enum(Role::class)],
            'user.status' => ['nullable', 'boolean', 'in:1,2'],
            'user.description' => ['nullable', 'string'],
        ];
    }

    public function mount()
    {
        $this->user = $this->hashid
            ? User::where('hashid', $this->hashid)->firstOrFail()
            : (new User);

        if (! $this->hashid) {
            $this->user->role = Role::Guest->value;
            $this->user->status = 1;
        }
    }

    public function render()
    {
        return view('livewire.users.form');
    }

    public function save()
    {
        $this->validate();

        if (! empty($this->user->password)) {
            $this->user->password = bcrypt($this->user->password);
        }

        $this->user->save();

        $this->redirectRoute('users.index');
    }

    public function delete()
    {
        $user = User::find($this->user->hashid);

        if ($user->hashid == request()->user()->hashid) {
            abort(403);
        }

        if (request()->user()->role !== Role::Developer->value) {
            abort(403);
        }

        $user->delete();

        $this->redirectRoute('users.index');
    }

    public function updatedUserStatus($value)
    {
        $this->user->status = (int) $value;
    }
}
