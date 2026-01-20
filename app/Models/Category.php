<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany
};

class Category extends Model
{
    public $timestamps = false;  
    protected $fillable = [
        'type_id',
        'name',
    ];

    public function type(): BelongsTo 
    {
        return $this->belongsTo(Type::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
