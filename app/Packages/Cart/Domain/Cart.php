<?php

namespace App\Packages\Cart\Domain;

class Cart
{
    public readonly CartId $cartId;
    public ProductList $productList;

    public function __construct(CartId $cartId, ProductList $productList)
    {
        $this->cartId = $cartId;
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
