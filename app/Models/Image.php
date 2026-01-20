<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'image_url',
        'is_primary',
    ];

    protected $casts = ['is_primary' => 'boolean'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
