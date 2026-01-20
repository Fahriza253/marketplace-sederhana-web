<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Finance extends Model
{
    use HasFactory;

    protected $primaryKey = 'finance_id';

    protected $fillable = [
        'transaction_id',
        'type',
        'amount',
        'description',
        'recorded_at',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
