<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasPrice;

    public function getPriceAttribute ($value) {
        if ($value === null) {
            return $this->product->price;
        }

        return new Money($value);
    }

    public function priceVaries() {
        return $this->price->amount() !== $this->product->price->amount();
    }

    public function type () {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function stocks () {
        return $this->hasMany(Stock::class, 'product_variation_id', 'id');
    }

    // this relationship is required to get info from view, but we need not all information but only pivot info
    // thus we use belongsToMany, and actually we don't require ProductVariation itself
    public function stock () {
        return $this->belongsToMany(
            ProductVariation::class,
            'product_variation_stock_view'
        )->withPivot([
            'stock',
            'in_stock'
        ]);
    }

    public function inStock () {
        return (bool) $this->stock->first()->pivot->in_stock;
//        return $this->stockCount() > 0;
    }

    public function minStock ($amount) {
        return min($this->stockCount(), $amount);
    }

    public function stockCount () {
        return  $this->stock->sum('pivot.stock');
    }

//    if product type has many product variations
//    public function type () {
//        return $this->belongsTo(ProductVariationType::class, 'product_variation_type_id', 'id');
//    }

    public function product () {
        return $this->belongsTo(Product::class);
    }
}
