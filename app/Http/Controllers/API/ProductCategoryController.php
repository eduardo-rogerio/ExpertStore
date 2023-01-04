<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductCategoryController extends Controller
{
    //api/product/{product}/categories
    public function index(Product $product)
    {
        return $product->categories;
    }
}
