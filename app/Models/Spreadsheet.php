<?php

namespace App\Models;

use App\Enums\Category;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Spreadsheet extends Model
{
    use Hashid;

    protected $primaryKey = 'hashid';

    public $incrementing = false;

    protected $fillable = [
        'filename',
        'category',
    ];

    protected $casts = [
        'category' => Category::class,
    ];

    public function url(): Attribute
    {
        return Attribute::get(fn () => Storage::disk('spreadsheets')->url($this->filename));
    }

    public function scopeFilenameLike($query, $title)
    {
        return $query->where('filename', 'like', '%'.$title.'%');
    }
}
