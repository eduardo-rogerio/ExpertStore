<?php

namespace Tests\Feature\API;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductPhotosControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_post_product_photos_endpoint_should_save_a_photo_by_upload()
    {
        Product::factory()
            ->create();

        $image = UploadedFile::fake()
            ->image('produto-foto.jpg');

        $response = $this->post('/api/products/1/photos', [
            'photos' => [
                $image,
            ],
        ]);

        Storage::disk('public')
            ->assertExists('products/' . $image->hashName());

    }
}
