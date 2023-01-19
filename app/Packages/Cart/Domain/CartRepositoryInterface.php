<?php

namespace App\Packages\Cart\Domain;

interface CartRepositoryInterface
{
    public function find(CartId $id);
    public function save(Cart $cart);
}