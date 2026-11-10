<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Tenancy extends Model
{
    //
protected $fillable = [
        'user_id',
        'unit_number',
        'monthly_rent',
        'current_balance',
    ];

    /**
     * Get the tenant user that owns the tenancy.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all payments recorded under this tenancy.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    }
