<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Payment extends Model
{
    //
    protected $fillable = [
        'user_id',
        'tenancy_id',
        'amount_paid',
        'reference_number', // e.g., M-Pesa transaction code
        'payment_date',
    ];

    /**
     * Get the user who made the payment.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the tenancy associated with the payment.
     */
    public function tenancy(): BelongsTo
    {
        return $this->belongsTo(Tenancy::class);
    }
}

