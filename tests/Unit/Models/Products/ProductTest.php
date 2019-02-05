<?php

namespace Tests\Unit\Models\Products;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_uses_the_slug_for_the_route_keyname()
    {
        $product = new Product();
        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }
}
