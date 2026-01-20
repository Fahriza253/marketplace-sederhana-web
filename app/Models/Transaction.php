<?php

namespace App\Models;

use Illuminate\Cache\HasCacheLock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
    HasOne,
};

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'buyer_name',
        'total_amount',
        'status',
        'payment_method',
        'channel',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class); 
    }

    public function finance(): HasOne
    {
        return $this->hasOne(Finance::class);
    }
}
