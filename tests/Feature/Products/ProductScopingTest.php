<?php

namespace Tests\Feature\Products;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductScopingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_scope_by_category () {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            $category = factory(Category::class)->create()
        );

        $anotherProduct = factory(Product::class)->create();

        $this->json('GET', "api/products?category={$category->slug}")
        ->assertJsonCount(1,  'data');
    }
}
