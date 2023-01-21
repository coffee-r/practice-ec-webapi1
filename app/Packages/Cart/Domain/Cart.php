<?php

namespace App\Packages\Cart\Domain;

class Cart
{
    public readonly CartId $cartId;
    public readonly UserId $userId;
    public ProductList $productList;

    public function __construct(CartId $cartId, UserId $userId, ProductList $productList)
    {
        $this->cartId = $cartId;
        $this->userId = $userId;
        $this->productList = $productList;
    }

    public function addProduct(Product $product)
    {
        $this->productList = $this->productList->add($product);
    }

    public function removeProduct(ProductId $productId)
    {
        $this->productList = $this->productList->remove($productId);
    }
}
