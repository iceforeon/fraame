<?php

namespace App\Models;

use App\Models\User;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Sluggable;
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
