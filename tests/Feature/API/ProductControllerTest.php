<?php

namespace Tests\Feature\API;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_product_get_endpoints_list_all_products()
    {
        Product::factory(3)
            ->create();

        $response = $this->getJson('/api/products');

        $response//->dd()
        ->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json->count('data', 3)
                ->etc();

            $json->has('data');

            $json->hasAll(['data.0.name', 'data.0.price', 'data.0.price_float']);

            $json->whereAllType([
                'data.0.name' => 'string',
                'data.0.price' => 'string',
                'data.0.price_float' => 'double',
            ]);
        });
    }

    public function test_should_product_get_endpoints_returns_a_single_product()
    {
        Product::factory(1)
            ->create(['name' => 'Produto 1', 'price' => 3999]);

        $response = $this->getJson('/api/products/1');

        $response
            ->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {

            $json->count('products', 4)
                ->has('products')
                ->hasAll(['products.name', 'products.price', 'products.price_float'])
                ->whereAllType([
                    'products.name' => 'string',
                    'products.price' => 'string',
                    'products.price_float' => 'double',
                ])
                ->whereAll([
                    'products.name' => 'Produto 1',
                    'products.price' => '3999',
                    'products.price_float' => 39.99,
                ]);
        });
    }

    public function test_should_product_post_endpoint_throw_an_unauthotized_status()
    {
        $response = $this->postJson('/api/products', []);
        $response->assertUnauthorized();
    }

    public function test_should_product_post_endpoint_create_a_new_product()
    {
        $product = [
            'name' => 'Produto Teste',
            'description' => 'Descrição Teste',
            'price' => 3999,
        ];

        $token = User::factory()
            ->create();
        $token = $token->createToken('default')->plainTextToken;

        $response = $this->postJson('/api/products', $product, ['Authorization' => 'Bearer ' . $token]);

        $response->assertCreated();

        $response->assertJson(function (AssertableJson $json) {

            $json->count('products', 3)
                ->has('products')
                ->hasAll(['products.name', 'products.price', 'products.price_float'])
                ->whereAllType([
                    'products.name' => 'string',
                    'products.price' => 'integer',
                    'products.price_float' => 'double',
                ])
                ->whereAll([
                    'products.name' => 'Produto Teste',
                    'products.price' => 3999,
                    'products.price_float' => 39.99,
                ]);
        });

    }

}
