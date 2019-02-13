<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartIndexTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fails_unauth()
    {
        $this->json('GET', 'api/cart')
            ->assertStatus(401);
    }

    public function test_it_shows_product_in_users_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = factory(ProductVariation::class)->create()
        );

        $response =$this->jsonAs($user,'GET', 'api/cart')
        ->assertJsonFragment([
            'id' => $product->id
        ]);
    }

    public function test_it_shows_is_cart_empty()
    {
        $user = factory(User::class)->create();

        $response =$this->jsonAs($user,'GET', 'api/cart')
            ->assertJsonFragment([
                'empty' => true
            ]);
    }

    public function test_it_shows_a_formatted_subtotal()
    {
        $user = factory(User::class)->create();

        $response =$this->jsonAs($user,'GET', 'api/cart')
            ->assertJsonFragment([
                'subtotal' => '£0.00'
            ]);
    }

    public function test_it_shows_a_formatted_total()
    {
        $user = factory(User::class)->create();

        $response =$this->jsonAs($user,'GET', 'api/cart')
            ->assertJsonFragment([
                'total' => '£0.00'
            ]);
    }
}
