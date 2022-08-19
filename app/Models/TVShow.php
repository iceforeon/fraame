<?php

namespace App\Models;

use App\Traits\Hashid;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class TVShow extends Model
{
    use Hashid;
    use Sluggable;
    use HasFactory;

    protected $table = 'tv_shows';

    protected $primaryKey = 'hashid';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'slug',
        'overview',
        'first_air_date',
        'genres',
        'poster_path',
        'frame_path',
        'tmdb_id',
        'imdb_id',
        'imdb_rating',
        'featured_at',
        'is_approved',
    ];

    protected $dates = [
        'first_air_date' => 'date:Y-m-d',
        'featured_at',
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

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
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

    public function scopeTodaysFeatured($query)
    {
        return $query->whereDate('featured_at', now()->startOfDay());
    }
}
