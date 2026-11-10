<?php

namespace App\Models;

use App\Traits\HasRolesAndPermission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRolesAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** Plain text assigned to the password is hashed; an existing bcrypt hash is kept as it is. */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = (is_string($value) && preg_match('/^\\$2[aby]\\$\\d{2}\\$.{53}$/', $value)) ? $value : \Illuminate\Support\Facades\Hash::make($value);
    }
}
