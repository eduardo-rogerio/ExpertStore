<?php

namespace Tests\Feature\API;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductPhotosControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_post_product_photos_endpoint_should_save_one_photo_by_upload()
    {
        $product = Product::factory()
            ->create();

        $image = UploadedFile::fake()
            ->image('produto-foto.jpg');

        $response = $this->post('/api/products/1/photos', [
            'photos' => [
                $image,
            ],
            [
                'Content-Type' => 'application/form-data',
            ],
        ]);

        Storage::disk('public')
            ->assertExists('products/' . $image->hashName());

        $this->assertEquals('products/' . $image->hashName(), $product->photos->first()->photo);
    }

    public function test_should_post_product_photos_endpoint_should_save_multiple_photo_by_upload()
    {
        $product = Product::factory()
            ->create();

        $image = UploadedFile::fake()
            ->image('produto-foto-1.jpg');

        $image2 = UploadedFile::fake()
            ->image('produto-foto-2.jpg');

        $image3 = UploadedFile::fake()
            ->image('produto-foto-3.jpg');

        $response = $this->post('/api/products/1/photos', [
            'photos' => [
                $image,
                $image2,
                $image3,
            ],
            [
                'Content-Type' => 'application/form-data',
            ],
        ]);

        Storage::disk('public')
            ->assertExists('products/' . $image->hashName());

        Storage::disk('public')
            ->assertExists('products/' . $image2->hashName());

        Storage::disk('public')
            ->assertExists('products/' . $image3->hashName());

        $photos = $product->photos;

        $this->assertEquals('products/' . $image->hashName(), $photos[0]->photo);
        $this->assertEquals('products/' . $image2->hashName(), $photos[1]->photo);
        $this->assertEquals('products/' . $image3->hashName(), $photos[2]->photo);
    }

    public function test_should_validate_uploaded_product_photos_as_image_mime_type()
    {
        $pdf = UploadedFile::fake()
            ->create('book.pdf', 1024, 'application/pdf');

        $product = Product::factory()
            ->create();

        $response = $this->post('/api/products/1/photos', [
            'photos' => [
                $pdf,
            ],
            [
                'Accept' => 'application/json',
            ],
        ]);

        $response->assertUnprocessable();

        $response->assertJson(function (AssertableJson $json) {

            $json->hasAll(['message', 'errors']);
        });

        $response->assertJsonValidationErrorFor('photos.0');
    }
}
