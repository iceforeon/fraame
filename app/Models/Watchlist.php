<?php

namespace App\Models;

use App\Traits\Hashid;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use Hashid;
    use Sluggable;
    use HasFactory;

    protected $primaryKey = 'hashid';

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'title',
        'slug',
        'items',
        'description',
        'user_id',
    ];

    protected function title(): Attribute
    {
        return Attribute::set(fn ($value) => trim(ucfirst($value)));
    }

    protected function description(): Attribute
    {
        return Attribute::set(fn ($value) => trim($value));
    }

    protected function items(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: function ($value) {
                $items = collect($value)->values()->map(function ($item, $key) {
                    return [
                        'order' => $key + 1,
                        'id' => $item['id'],
                        'title' => $item['title'],
                        'year_released' => $item['year_released'],
                    ];
                });

                return json_encode($items);
            },
        );
    }

    public function scopeTitleLike($query, $title)
    {
        return $query->where('title', 'like', '%'.$title.'%');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
