<?php

namespace App\Packages\Cart\Usecase;

use App\Packages\Cart\Domain\CartId;
use App\Packages\Cart\Domain\CartRepositoryInterface;
use App\Packages\Cart\Domain\ProductFactoryInterface;
use App\Packages\Cart\Domain\ProductId;
use App\Packages\Cart\Domain\ProductQuantity;
use Illuminate\Support\Facades\DB;

class CartProductAddAction
{
    private readonly CartRepositoryInterface $cartRepository;
    private readonly ProductFactoryInterface $productFactory;

    public function __construct(CartRepositoryInterface $cartRepository, ProductFactoryInterface $productFactory)
    {
        $this->cartRepository = $cartRepository;
        $this->productFactory = $productFactory;
    }

    public function __invoke(CartProductAddCommand $cartProductAddCommand)
    {
        $cart = DB::transaction(function () use ($cartProductAddCommand) {
            $cart = $this->cartRepository->find(new CartId($cartProductAddCommand->cartId));
        
            $product = $this->productFactory->create(new ProductId($cartProductAddCommand->productId), new ProductQuantity($cartProductAddCommand->productQuantity));

            $cart->addProduct($product);

            // $cart->tryTransferYupacketProduct();

            $this->cartRepository->save($cart);

            return $cart;
        });

        return new CartData($cart);
    }
}
