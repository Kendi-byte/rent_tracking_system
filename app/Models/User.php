<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
   use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'landlord', 'caretaker', 'tenant'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the tenancy details for the user.
     */
    public function tenancy(): HasOne
    {
        return $this->hasOne(Tenancy::class);
    }

    /**
     * Get all payment records for the user.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}