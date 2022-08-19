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
        'imported_at',
    ];

    protected $dates = [
        'imported_at',
    ];

    protected $casts = [
        'category' => Category::class,
    ];

    public function filenameFormatted(): Attribute
    {
        return Attribute::get(fn () => "{$this->filename} ({$this->category->value})");
    }

    public function url(): Attribute
    {
        return Attribute::get(fn () => Storage::disk('spreadsheets')->url($this->filename));
    }

    public function importedAtForHuman(): Attribute
    {
        return Attribute::get(fn () => $this->imported_at ? $this->imported_at->timezone('Asia/Manila')->format('D, d F Y (H:m a)') : '---');
    }

    public function scopeFilenameLike($query, $title)
    {
        return $query->where('filename', 'like', '%'.$title.'%');
    }
}
