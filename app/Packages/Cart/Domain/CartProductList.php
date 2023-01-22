<?php

namespace App\Packages\Cart\Domain;

use App\Packages\Shared\Domain\DomainException;

class CartProductList
{
    public readonly array $value;
    
    public function __construct(array $value){
        if(count($value) == 0){
            $this->value = [];
            return;
        }

        foreach ($value as $key => $cartProduct) {
            if(($cartProduct instanceof CartProduct) == false){
                throw new DomainException('商品リストには商品のみを入れられます');
            }
        }
        $this->value = $value;
        
    }

    public function add(CartProduct $addCartProduct) : CartProductList{
        $value = $this->value;

        // 数量追加の場合
        foreach ($value as $key => $cartProduct) {
            if($cartProduct->productId == $addCartProduct->productId){
                $value[$key]->productQuantity = $value[$key]->productQuantity->add($addCartProduct->productQuantity);
                return new CartProductList($value);
            }
        }

        $value[] = $addCartProduct;
        return new CartProductList($value);
    }

    public function remove(ProductId $removeCartProductId) : CartProductList{

        $value = $this->value;

        foreach ($value as $key => $cartProduct) {
            if($cartProduct->productId == $removeCartProductId){
                unset($value[$key]);
                return new CartProductList($value);
            }
        }

        throw new DomainException('削除できる商品が見つかりませんでした');
    }

    public function sumQuantity(){
        $quantity = 0;

        foreach ($this->value as $key => $product) {
            $quantity += $product->productQuantity->value;
        }

        return $quantity;
    }

    /**
     * ゆうパケット商品に振り替える
     *
     * @return CartProductList
     */
    public function tryTransferToYupacketProduct()
    {
        $cartProductList = $this->value;

        // カート内商品が単品でない時は振替えない
        if ($this->sumQuantity() !== 1) {
            return new CartProductList($cartProductList);
        }

        foreach ($cartProductList as $key => $cartProduct) {
            // 振り替え商品が設定されていない商品は無視
            if ($cartProduct->yupacketTransferAfterProduct == null) {continue;}
            
            // 振り替え
            $cartProductList[$key] = new CartProduct(
                $cartProduct->yupacketTransferAfterProduct->productId,
                $cartProduct->yupacketTransferAfterProduct->productName,
                $cartProduct->yupacketTransferAfterProduct->productPriceWithTax,
                $cartProduct->yupacketTransferAfterProduct->productTax,
                $cartProduct->yupacketTransferAfterProduct->productPointPrice,
                $cartProduct->toProduct(),
                null,
                new ProductQuantity(1)
            );
        }

        return new CartProductList($cartProductList);
    }

    /**
     * ゆうパケット商品でない商品に振り替える
     *
     * @return CartProductList
     */
    public function tryTransferToNotYupacketProduct(){

        $cartProductList = $this->value;

        // カート内商品が単品の時は振り戻さない
        if ($this->sumQuantity() === 1) {
            return new CartProductList($cartProductList);
        }

        foreach ($cartProductList as $key => $cartProduct) {
            // 振り戻し商品が設定されていない商品は無視
            if ($cartProduct->yupacketTransferBeforeProduct == null) {continue;}
            
            // 振り戻し
            $cartProductList[$key] = new CartProduct(
                $cartProduct->yupacketTransferBeforeProduct->productId,
                $cartProduct->yupacketTransferBeforeProduct->productName,
                $cartProduct->yupacketTransferBeforeProduct->productPriceWithTax,
                $cartProduct->yupacketTransferBeforeProduct->productTax,
                $cartProduct->yupacketTransferBeforeProduct->productPointPrice,
                null,
                $cartProduct->toProduct(),
                $cartProduct->productQuantity
            );
        }

        return new CartProductList($cartProductList);
    }
}
