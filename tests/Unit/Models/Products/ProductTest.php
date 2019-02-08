<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Stock;
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

    public function test_it_has_many_categories () {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            factory(Category::class)->make()
        );

        $this->assertInstanceOf(Category::class,$product->categories->first());
    }

    public function test_it_has_many_variations () {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            factory(ProductVariation::class)->make()
        );

        $this->assertInstanceOf(ProductVariation::class,$product->variations->first());
    }

    public function test_it_returns_money_instance_for_price () {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Money::class,$product->price);
    }

    public function test_it_returns_formatted_price () {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);

        $this->assertEquals($product->formatted_price, '£10.00');
    }

    public function test_it_can_check_it_is_in_stock () {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            $variation = factory(ProductVariation::class)->make()
        );

        $variation->stocks()->save(
            factory(Stock::class)->make()
        );

        $this->assertTrue($product->inStock());
    }

    public function test_it_can_get_the_stock_count () {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            $variation = factory(ProductVariation::class)->make()
        );

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertEquals($product->stockCount(), $quantity);
    }
}
