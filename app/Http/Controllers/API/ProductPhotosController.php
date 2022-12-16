<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ProductPhotosStoreRequest;
use App\Models\Product;

class ProductPhotosController extends Controller
{
    public function store(Product $product, ProductPhotosStoreRequest $request)
    {
        $files = $request->photos;

        $photos = [];

        foreach ($files as $file) {
            $photos[] = ['photo' => $file->store('products', 'public')];
        }

        $product->photos()
            ->createMany($photos);
    }
}
