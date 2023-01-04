<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['photo', 'is_thumb', 'product_id'];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
