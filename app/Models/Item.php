<?php

namespace App\Models;

use App\Enums\ItemType;
use App\Traits\Hashid;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Hashid;
    use Sluggable;
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'overview',
        'release_date',
        'tmdb_id',
        'poster_path',
        'imdb_id',
        'imdb_rank',
        'imdb_rating',
        'ticket_image',
        'posted_at',
    ];

    protected $cast = [
        'type' => ItemType::class,
        'imdb_rank' => 'integer',
    ];

    protected $dates = [
        'release_date',
        'posted_at',
    ];

    protected function title(): Attribute
    {
        return Attribute::set(fn ($value) => trim($value));
    }

    protected function titleFormatted(): Attribute
    {
        return Attribute::get(fn () => "{$this->title} ({$this->release_date->format('Y')})");
    }

    public function scopeTitleLike($query, $title)
    {
        return $query->where('title', 'like', '%'.$title.'%');
    }
}
