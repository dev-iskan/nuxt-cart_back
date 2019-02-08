<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    public function type () {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

//    if product type has many product variations
//    public function type () {
//        return $this->belongsTo(ProductVariationType::class, 'product_variation_type_id', 'id');
//    }

    public function product () {
        return $this->belongsTo(Product::class);
    }
}
