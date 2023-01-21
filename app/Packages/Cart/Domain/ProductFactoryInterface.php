<?php

namespace App\Packages\Cart\Domain;

interface ProductFactoryInterface
{
    public function create(ProductId $productId, ProductQuantity $productQuantity) : Product;
}