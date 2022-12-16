<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPhotosController extends Controller
{
    public function store(Product $product, Request $request)
    {
        $files = $request->photos;

        foreach ($files as $file) {
            $file->store('products', 'public');
        }
    }
}
