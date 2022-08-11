<?php

namespace App\Models;

use App\Traits\Hashid;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    use Hashid;
    use Sluggable;
    use HasFactory;

    protected $primaryKey = 'hashid';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'slug',
        'overview',
        'release_date',
        'genres',
        'tmdb_id',
        'tmdb_poster_path',
        'poster_path',
        'imdb_id',
        'imdb_rating',
        'posted_at',
    ];

    protected $dates = [
        'release_date' => 'date:Y-m-d',
        'posted_at',
    ];

    protected function title(): Attribute
    {
        return Attribute::set(fn ($value) => trim($value));
    }

    protected function titleFormatted(): Attribute
    {
        return Attribute::get(fn () => "{$this->title} (".Carbon::parse($this->release_date)->format('Y').')');
    }

    public function yearReleased(): Attribute
    {
        return Attribute::get(fn () => Carbon::parse($this->release_date)->format('Y'));
    }

    public function updatedAtForHuman(): Attribute
    {
        return Attribute::get(fn () => $this->updated_at->format('F d, Y'));
    }

    public function posterUrl(): Attribute
    {
        return Attribute::get(fn () => Storage::disk('media')->url($this->poster_path));
    }

    public function scopeTitleLike($query, $title)
    {
        return $query->where('title', 'like', '%'.$title.'%');
    }

    public function scopeImdbRating($query, $sort = 'desc')
    {
        return $query->orderBy('imdb_rating', $sort);
    }

    public function scopeHasPoster($query)
    {
        return $query->whereNotNull('poster_path');
    }
}
