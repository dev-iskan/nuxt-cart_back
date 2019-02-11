<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartUpdateTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fails_unauth()
    {
        //id doesn't matter as anyway throw 401
        $this->json('PATCH', 'api/cart/1')
            ->assertStatus(401);
    }

    public function test_it_fails_if_no_product()
    {
        $user = factory(User::class)->create();
        $this->jsonAs($user,'PATCH', 'api/cart/1')
            ->assertStatus(404);
    }

    public function test_it_requires_quantity()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->jsonAs($user,'PATCH', "api/cart/{$product->id}")
            ->assertJsonValidationErrors(['quantity']);
    }

    public function test_it_requires_numeric_quantity()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->jsonAs($user,'PATCH', "api/cart/{$product->id}", [
            'quantity' => 'none'
        ])
            ->assertJsonValidationErrors(['quantity']);
    }

    public function test_it_requires_quantity_one_or_moer()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->jsonAs($user,'PATCH', "api/cart/{$product->id}", [
            'quantity' => 0
        ])
            ->assertJsonValidationErrors(['quantity']);
    }

    public function test_it_updates_quantity()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(), [
                'quantity' => 1
            ]
        );

        $this->jsonAs($user,'PATCH', "api/cart/{$product->id}", [
            'quantity' => $quantity = 5
        ]);

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'quantity' => $quantity
        ]);
    }
}
