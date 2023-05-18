<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    public const TYPE_ADMIN = 1;
    public const TYPE_REALTOR = 2;
    public const TYPE_MODERATOR = 3;

    protected $fillable = [
        'user_id',
        'avatar_url',
        'type',
    ];

    protected $appends = [
        'avatar_file',
    ];

    public static function allTypes()
    {
        return [self::TYPE_ADMIN, self::TYPE_REALTOR, self::TYPE_MODERATOR];
    }

    public static function typesWithoutAdmin()
    {
        return [self::TYPE_REALTOR, self::TYPE_MODERATOR];
    }

    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
    }

    public function isRealtor(): bool
    {
        return $this->type === self::TYPE_REALTOR;
    }

    public function isModerator(): bool
    {
        return $this->type === self::TYPE_MODERATOR;
    }

    public function avatarFile(): Attribute
    {
        return new Attribute(
            get: fn() => last(explode('/', $this->avatar_url))
        );
    }

    public function scopeAdmins(Builder $query)
    {
        $query->where('type', self::TYPE_ADMIN);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
