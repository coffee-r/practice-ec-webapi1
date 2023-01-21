<?php

namespace App\Packages\Cart\Infrastructure;

use App\Models\Cart as ModelCart;
use App\Models\Product as ModelProduct;
use App\Models\CartProduct as ModelCartProduct;
use App\Packages\Cart\Domain\Cart;
use App\Packages\Cart\Domain\CartId;
use App\Packages\Cart\Domain\CartProduct;
use App\Packages\Cart\Domain\CartProductList;
use App\Packages\Cart\Domain\CartRepositoryInterface;
use App\Packages\Cart\Domain\ProductId;
use App\Packages\Cart\Domain\ProductName;
use App\Packages\Cart\Domain\ProductQuantity;
use App\Packages\Cart\Domain\ProductUnitPointPrice;
use App\Packages\Cart\Domain\ProductUnitPriceWithTax;
use App\Packages\Cart\Domain\ProductUnitTax;
use App\Packages\Cart\Domain\UserId;

class CartRepository implements CartRepositoryInterface
{
    public function find(CartId $cartId) : Cart | null
    {
        $modelCart = ModelCart::find($cartId->value);

        if(empty($modelCart)){
            return null;
        }
        
        $modelCartProductList = ModelCartProduct::where('cart_id', $cartId->value)->get();

        $cartProductList = new CartProductList([]);

        foreach ($modelCartProductList as $key => $modelCartProduct) {
            $cartProductList = $cartProductList->add(new CartProduct(
                new ProductId($modelCartProduct->product_id),
                new ProductName($modelCartProduct->product_name),
                new ProductUnitPriceWithTax($modelCartProduct->product_price_with_tax),
                new ProductUnitTax($modelCartProduct->product_tax),
                new ProductUnitPointPrice($modelCartProduct->product_point_price),
                new ProductQuantity($modelCartProduct->product_quantity)
            ));
        }

        return new Cart($cartId, new UserId($modelCart->user_id), $cartProductList);
    }

    public function save(Cart $cart)
    {
        ModelCart::insertOrIgnore([
            'id' => $cart->cartId->value,
            'user_id' => $cart->userId->value
        ]);

        ModelCartProduct::where('cart_id', $cart->cartId->value)->delete();

        $cartProducts = [];

        foreach ($cart->cartProductList->value as $key => $cartProduct) {
            $element = [];
            $element['cart_id'] = $cart->cartId->value;
            $element['product_id'] = $cartProduct->productId->value;
            $element['product_name'] = $cartProduct->productName->value;
            $element['product_price_with_tax'] = $cartProduct->productPriceWithTax->value;
            $element['product_tax'] = $cartProduct->productTax->value;
            $element['product_point_price'] = $cartProduct->productPointPrice->value;
            $element['product_quantity'] = $cartProduct->productQuantity->value;
            
            $cartProducts[] = $element;
        }

        if(count($cartProducts) > 0){
            ModelCartProduct::insert($cartProducts);
        }
    }
}