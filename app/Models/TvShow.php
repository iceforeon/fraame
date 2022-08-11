<?php

namespace App\Models;

use App\Traits\Hashid;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvShow extends Model
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
        'first_air_date',
        'genres',
        'poster_path',
        'frame_path',
        'tmdb_id',
        'imdb_id',
        'imdb_rating',
        'posted_at',
    ];

    protected $dates = [
        'first_air_date',
        'posted_at',
    ];

    protected function title(): Attribute
    {
        return Attribute::set(fn ($value) => trim($value));
    }

    protected function titleFormatted(): Attribute
    {
        $year = $this->first_air_date ? "({$this->first_air_date->format('Y')})" : null;

        return Attribute::get(fn () => "{$this->title} {$year}");
    }

    public function yearReleased(): Attribute
    {
        return Attribute::get(fn () => $this->first_air_date
            ? $this->first_air_date->format('Y')
            : null);
    }

    public function scopeTitleLike($query, $title)
    {
        return $query->where('title', 'like', '%'.$title.'%');
    }

    public function scopeImdbRank($query, $sort = 'asc')
    {
        return $query->orderBy('imdb_rank', $sort);
    }

    public function scopeHasPoster($query)
    {
        return $query->whereNotNull('poster_path');
    }
}
