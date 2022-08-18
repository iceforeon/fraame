<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CurrentPassword implements Rule
{
    public function passes($attribute, $value)
    {
        $user = request()->user();

        if (! $user->hasPassword()) {
            return true;
        }

        return Hash::check($value, $user->password);
    }

    public function message()
    {
        return 'Invalid password.';
    }
}
