<?php

namespace App\Packages\Cart\Usecase;

use App\Packages\Cart\Domain\Cart;
use App\Packages\Cart\Domain\CartFactoryInterface;
use App\Packages\Cart\Domain\CartId;
use App\Packages\Cart\Domain\CartRepositoryInterface;
use App\Packages\Cart\Domain\ProductId;
use App\Packages\Cart\Domain\ProductList;
use App\Packages\Cart\Domain\ProductQuantity;
use App\Packages\Cart\Domain\UserId;
use Illuminate\Support\Facades\DB;

class CartCreateAction
{
    private readonly CartRepositoryInterface $cartRepository;
    private readonly CartFactoryInterface $cartFactory;

    public function __construct(CartRepositoryInterface $cartRepository, CartFactoryInterface $cartFactory)
    {
        $this->cartRepository = $cartRepository;
        $this->cartFactory = $cartFactory;
    }

    public function __invoke(int $userId)
    {
        $cart = DB::transaction(function () use ($userId) {
            $cart = $this->cartFactory->create(new UserId($userId), new ProductList([]));
            $this->cartRepository->save($cart);
            return $cart;
        });

        return new CartData($cart);
    }
}
