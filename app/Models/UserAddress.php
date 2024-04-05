<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'province', 'city', 'district', 'address', 'zip',
        'contact_name', 'contact_phone', 'last_used_at',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fullAddress(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                return "{$attributes['province']}{$attributes['city']}{$attributes['district']}{$attributes['address']}";
            }
        );
    }
}
