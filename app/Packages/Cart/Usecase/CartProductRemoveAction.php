<?php

namespace App\Packages\Cart\Usecase;

use App\Packages\Cart\Domain\CartId;
use App\Packages\Cart\Domain\CartRepositoryInterface;
use App\Packages\Cart\Domain\ProductId;
use Illuminate\Support\Facades\DB;


class CartProductRemoveAction
{
    private readonly CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function __invoke(CartProductRemoveCommand $cartProductRemoveCommand)
    {
        $cart = DB::transaction(function () use ($cartProductRemoveCommand) {
            $cart = $this->cartRepository->find(new CartId($cartProductRemoveCommand->cartId));
        
            $productId = new ProductId($cartProductRemoveCommand->productId);

            $cart->removeProduct($productId);

            // $cart->tryTransferYupacket();

            $this->cartRepository->save($cart);

            return $cart;
        });

        return new CartData($cart);
        
    }
}
