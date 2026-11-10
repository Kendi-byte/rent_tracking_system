<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    // status and confirmed_by are intentionally NOT fillable:
    // they are set by the confirm/reject action, never by form input.
    protected $fillable = [
        'tenancy_id',
        'amount',
        'mpesa_reference',
        'month_paid_for',
    ];

    public function tenancy(): BelongsTo
    {
        return $this->belongsTo(Tenancy::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}