<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Administrator
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $name 姓名
 * @property string $password 密码
 * @property string|null $avatar 头像
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $avatar_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\AdministratorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator query()
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator withoutTrashed()
 * @mixin \Eloquent
 */
class Administrator extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    FilamentUser,
    HasAvatar
{
    use HasFactory, Authenticatable, Authorizable, SoftDeletes, HasRoles;

    protected $fillable = [
        'username',
        'name',
        'password',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['avatar'] ? Storage::url($attributes['avatar']) : null
        );
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}
