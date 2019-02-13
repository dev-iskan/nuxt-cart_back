<?php

namespace App\Cart;

use App\Models\User;

class Cart {
    protected $user;
    protected $changed = false;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function add ($products) {
        $this->user->cart()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );
    }

    public function update ($productId, $quantity) {
        //update existing cart  item
        $this->user->cart()->updateExistingPivot($productId, [
            'quantity' => $quantity
        ]);
    }

    public function delete ($productId) {
        $this->user->cart()->detach($productId);
    }

    public function empty () {
        $this->user->cart()->detach();
    }

    public function isEmpty () {
        return $this->user->cart->sum('pivot.quantity') === 0;
    }

    public function subtotal () {
        $subtotal = $this->user->cart->sum(function ($product) {
            return $product->price->amount() * $product->pivot->quantity;
        });

        return new Money($subtotal);
    }

    public function total () {
        //add more things
        return $this->subtotal();
    }

    public function sync () {

        $this->user->cart->each(function ($product) {
            //min quantity
            $quantity = $product->minStock($product->pivot->quantity);

            $this->changed = $quantity != $product->pivot->quantity;

            $product->pivot->update([
                'quantity' => $quantity
            ]);
        });
    }

    public function hasChanged () {
        return $this->changed;
    }

    protected function getStorePayload($products) {
        //create collection by key as id using keyBy method
        return collect($products)->keyBy('id')->map(function ($product) {
            return [
                // get current quantity and increment if same id sent
                'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
            ];
        })->toArray();
    }

    protected function getCurrentQuantity ($product_id)  {
        if ($product = $this->user->cart->where('id', $product_id)->first()) {
            return $product->pivot->quantity;
        }
        return 0;
    }
}