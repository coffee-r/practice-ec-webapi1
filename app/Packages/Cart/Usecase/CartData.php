<?php

namespace App\Packages\Cart\Usecase;

use App\Packages\Cart\Domain\Cart;

class CartData
{
    public readonly string $cartId;
    public readonly array $productList;

    public function __construct(Cart $cart)
    {
        $this->cartId = $cart->cartId->value;
        $productList = [];
        foreach ($cart->productList->value as $key => $product) {
            $productList[] = new ProductData($product);
        }
    }
}