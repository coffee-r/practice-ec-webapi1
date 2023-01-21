<?php

namespace App\Packages\Cart\Domain;

interface CartFactoryInterface
{
    public function create(UserId $userId, ProductList $productList) : Cart;
}