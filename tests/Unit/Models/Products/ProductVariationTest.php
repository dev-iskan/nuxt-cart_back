<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_one_variation_type()
    {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(ProductVariationType::class, $variation->type);
    }

    public function test_it_belongs_to_a_product()
    {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(Product::class, $variation->product);
    }

    public function test_it_returns_money_instance_for_price () {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(Money::class, $variation->price);
    }

    public function test_it_returns_formatted_price () {
        $variation = factory(ProductVariation::class)->create([
            'price' => 1000
        ]);

        $this->assertEquals($variation->formatted_price, '£10.00');
    }

    public function test_it_returns_product_price_if_own_null () {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);

        $variation = factory(ProductVariation::class)->create([
            'price' => null,
            'product_id' => $product->id
        ]);

        $this->assertEquals($product->price->amount(),  $variation->price->amount());
    }

    public function test_it_can_check_difference_in_price () {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);

        $variation = factory(ProductVariation::class)->create([
            'price' => 2000,
            'product_id' => $product->id
        ]);

        $this->assertTrue($variation->priceVaries());
    }

    public function test_it_has_many_stocks () {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
            factory(Stock::class)->make()
        );

        $this->assertInstanceOf(Stock::class, $variation->stocks->first());
    }

    public function test_it_has_stock_information () {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
            factory(Stock::class)->make()
        );

        $this->assertInstanceOf(ProductVariation::class, $variation->stock->first());
    }

    public function test_it_has_stock_count_pivot_within_stock () {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertEquals($variation->stock->first()->pivot->stock, $quantity);
    }

    public function test_it_has_in_stock_pivot_within_stock () {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertTrue($variation->stock->first()->pivot->in_stock);
    }

    public function test_it_has_in_stock_method () {
        $variation = factory(ProductVariation::class)->create();

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertTrue($variation->inStock());
    }

    public function test_it_has_stock_count_method () {
        $variation = factory(ProductVariation::class)->create();
        $quantity = 0;
        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => 5
            ])
        );

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => 5
            ])
        );

        $this->assertEquals($variation->stockCount(), 10);
    }
}
