<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartDestroyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fails_unauth()
    {
        $this->json('DELETE', 'api/cart/1')
            ->assertStatus(401);
    }

    public function test_it_can_be_found_products()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'DELETE', "api/cart/1")
            ->assertStatus(404);
    }

    public function test_it_deletes_item_from_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = factory(ProductVariation::class)->create()
        );

        $response = $this->jsonAs($user,'DELETE', "api/cart/{$product->id}");
        $this->assertDatabaseMissing('cart_user', [
            'product_variation_id' => $product->id
        ]);
    }
}
