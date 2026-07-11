<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
    HasOne
};
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'status', // NOTE: This is enum
        'condition',
        'sold_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sold_at' => 'datetime',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(VehicleProduct::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(Image::class)->where('is_primary', true);
    }

    public function scopeAvailable(Builder $query)
    {
        return $query->where('status', 'available');
    }

    public function scopeNewest(Builder $query)
    {
        return $query->latest();
    }

    public function scopeBasicRelations(Builder $query)
    {
        return $query->with([
            'seller:id,name',
            'primaryImage:id,product_id,image_url'
        ]);
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->vehicle()->delete();
            $product->images()->delete();
        });
    }
}
