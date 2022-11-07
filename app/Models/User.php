<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => bcrypt($value)
        );
    }

    public static function getById($id)
    {
        return User::find($id);
    }

    public static function deleteById($id)
    {
        User::getById($id)
            ->delete();
    }

    public static function getAllCached()
    {
        return Cache::remember('users_all', env('CACHE_TIME_FOR_DATA'), function () {
            return User::all();
        });
    }

    public static function clearCache()
    {
        return Cache::forget('users_all');
    }

    public static function getAdmins()
    {
        return User::where('is_admin', 1)->get();
    }

    public static function getAmount()
    {
        return User::count('id');
    }
}
