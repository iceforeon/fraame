<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Iceforeon',
            'username' => 'ife',
            'email' => 'iceforeon@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
