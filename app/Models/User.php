<?php

namespace App\Models;

use App\Enums\Role;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Hashid;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'description',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function nameFormatted(): Attribute
    {
        return Attribute::get(fn () => "{$this->name} ({$this->username})");
    }

    public function hasPassword()
    {
        return ! is_null($this->password);
    }

    public function isDeveloper()
    {
        return $this->role == Role::Developer->value;
    }

    public function isGuest()
    {
        return $this->role == Role::Guest->value;
    }

    public function isEditor()
    {
        return $this->role == Role::Editor->value;
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }

    public function scopeNotMe($query)
    {
        return $query->where('id', '<>', request()->user()->id);
    }

    public function scopeNotDev($query)
    {
        return $query->where('role', '<>', Role::Developer->value);
    }
}
