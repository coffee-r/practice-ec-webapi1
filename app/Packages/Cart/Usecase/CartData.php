<?php

namespace App\Packages\Cart\Usecase;

use App\Packages\Cart\Domain\Cart;

class CartData
{
    public readonly int $cartId;
    public readonly int $userId;
    public readonly array $productList;

    public function __construct(Cart $cart)
    {
        $this->cartId = $cart->cartId->value;
        $this->userId = $cart->userId->value;
        $productList = [];
        foreach ($cart->productList->value as $key => $product) {
            $productList[] = new ProductData($product);
        }
        $this->productList = $productList;
    }
}