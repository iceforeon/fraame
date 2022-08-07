<?php

namespace App\Models;

use App\Traits\Hashid;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Hashid;
    use Sluggable;
    use HasFactory;

    const TYPES = [
        'movie',
        'tv-series',
        // 'anime'
    ];

    protected $fillable = [
        'title',
        'slug',
        'tmdb_id',
        'ticket_image',
        'posted_at',
        'type',
    ];

    protected $dates = [
        'posted_at',
    ];

    protected function title(): Attribute
    {
        return Attribute::set(fn ($value) => trim($value));
    }
}
