<?php

namespace Database\Seeders;

use App\Models\Post;
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

        Post::create([
            'title' => 'Excepteur eu et cillum minim culpa id',
            'content' => 'Laboris amet ut mollit est eu et incididunt pariatur',
            'user_id' => 1000,
        ]);
    }
}
