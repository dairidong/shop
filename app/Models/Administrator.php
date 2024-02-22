<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Administrator extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    FilamentUser
{
    use HasFactory, Authenticatable, Authorizable, SoftDeletes;

    protected $fillable = [
        'username',
        'name',
        'password',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        ''
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
