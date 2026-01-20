<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleProduct extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'brand',
        'model',
        'year',
        'engine_capacity',
        'license_plate',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
