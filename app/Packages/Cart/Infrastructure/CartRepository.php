<?php

namespace App\Packages\Cart\Infrastructure;

use App\Models\Cart as ModelCart;
use App\Models\Product as ModelProduct;
use App\Models\CartProduct as ModelCartProduct;
use App\Packages\Cart\Domain\Cart;
use App\Packages\Cart\Domain\CartId;
use App\Packages\Cart\Domain\CartRepositoryInterface;
use App\Packages\Cart\Domain\Product;
use App\Packages\Cart\Domain\ProductId;
use App\Packages\Cart\Domain\ProductList;
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

        $productList = new ProductList([]);

        foreach ($modelCartProductList as $key => $modelCartProduct) {
            $productList = $productList->add(new Product(
                new ProductId($modelCartProduct->product_id),
                new ProductName($modelCartProduct->product_name),
                new ProductUnitPriceWithTax($modelCartProduct->product_price_with_tax),
                new ProductUnitTax($modelCartProduct->product_tax),
                new ProductUnitPointPrice($modelCartProduct->product_point_price),
                new ProductQuantity($modelCartProduct->product_quantity)
            ));
        }

        return new Cart($cartId, new UserId($modelCart->user_id), $productList);
    }

    public function save(Cart $cart)
    {
        ModelCart::insertOrIgnore([
            'id' => $cart->cartId->value,
            'user_id' => $cart->userId->value
        ]);

        ModelCartProduct::where('cart_id', $cart->cartId->value)->delete();

        $cartProducts = [];

        foreach ($cart->productList->value as $key => $product) {
            $cartProduct = [];
            $cartProduct['cart_id'] = $cart->cartId->value;
            $cartProduct['product_id'] = $product->productId->value;
            $cartProduct['product_name'] = $product->productName->value;
            $cartProduct['product_price_with_tax'] = $product->productPriceWithTax->value;
            $cartProduct['product_tax'] = $product->productTax->value;
            $cartProduct['product_point_price'] = $product->productPointPrice->value;
            $cartProduct['product_quantity'] = $product->productQuantity->value;
            
            $cartProducts[] = $cartProduct;
        }

        if(count($cartProducts) > 0){
            ModelCartProduct::insert($cartProducts);
        }
    }
}