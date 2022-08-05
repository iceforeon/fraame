<?php

namespace App\Models;

use App\Traits\Hashid;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Hashid;
    use Sluggable;
    use HasFactory;

    protected $primaryKey = 'hashid';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'slug',
        'content',
    ];

    protected function title(): Attribute
    {
        return Attribute::set(fn ($value) => str()->of($value)->trim()->ucfirst()->toString());
    }

    protected function content(): Attribute
    {
        return Attribute::set(fn ($value) => str()->of($value)->trim()->toString());
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
