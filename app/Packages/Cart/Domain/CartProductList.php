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

    // public function sumQuantity(){
    //     $quantity = 0;

    //     foreach ($this->value as $key => $product) {
    //         $quantity += $product->productQuantity->value;
    //     }

    //     return $quantity;
    // }

    // public function tryTransferYupacketProduct()
    // {
    //     $productList = $this->value;

    //     // 振り替え
    //     if($this->sumQuantity() === 1){
    //         foreach ($productList as $key => $product) {
    //             if($product->yupacketTransferAfterProduct != null){
    //                 $productList[$key] = $product->yupacketTransferAfterProduct;
    //                 return $productList;
    //             }
    //         }
    //     }

    //     // 振り戻し
    //     if($this->sumQuantity() > 1){
    //         foreach ($productList as $key => $product) {
    //             if($product->yupacketTransferBeforeProduct != null){
    //                 $productList[$key] = $product->yupacketTransferBeforeProduct;
    //                 return $productList;
    //             }
    //         }
    //     }

    //     // 振り替えも振り戻しもなかった時
    //     return $productList;
    // }
}
