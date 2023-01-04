<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'photo_id'];

    protected $appends = ['price_float'];

    protected $with = ['categories'];

    protected $withCount = ['categories'];

    public function priceFloat(): Attribute
    {
        return new Attribute(
            get: fn($price) => $this->attributes['price'] / 100
        );
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

}
