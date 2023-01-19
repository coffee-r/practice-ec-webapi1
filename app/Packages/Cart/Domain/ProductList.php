<?php

namespace App\Packages\Cart\Domain;

use App\Packages\Shared\Domain\DomainException;

class ProductList
{
    public readonly array $value;
    
    public function __construct(array $value){
        if(count($value) == 0){
            $this->value = [];
            return;
        }

        foreach ($value as $key => $product) {
            if(($product instanceof Product) == false){
                throw new DomainException('商品リストには商品のみを入れられます');
            }
        }
        $this->value = $value;
        
    }

    public function add(Product $addProduct) : ProductList{
        $value = $this->value;

        // 数量追加の場合
        foreach ($value as $key => $product) {
            if($product->productId == $addProduct->productId){
                $value[$key]->productQuantity->value += $addProduct->productQuantity->value;
                return new ProductList($value);
            }
        }

        $value[] = $product;
        return new ProductList($value);
    }

    public function remove(ProductId $removeProductId) : ProductList{

        $value = $this->value;

        foreach ($value as $key => $product) {
            if($product->productId == $removeProductId){
                unset($value[$key]);
                return new ProductList($value);
            }
        }

        throw new DomainException('削除できる商品が見つかりませんでした');
    }

    private function sumQuantity(){
        $quantity = 0;

        foreach ($this->value as $key => $product) {
            $quantity += $product->productQuantity->value;
        }

        return $quantity;
    }

    /**
     * 通常の商品からゆうパケット商品に振り替えるべきか
     *
     * @return boolean
     */
    public function shouldBeYupacketTransfer(){
        if($this->sumQuantity() !== 1){
            return false;
        }

        foreach ($this->value as $key => $product) {
            if($product->yupacketTransferProductId != null){
                return true;
            }
        }

        return false;
    }

    /**
     * ゆうパケット商品から通常の商品に振り戻すべきか
     *
     * @param Cart $cart
     * @return boolean
     */
    public function shouldBeYupacketTransferBack(){
        if($this->sumQuantity() === 1){
            return false;
        }

        foreach ($this->value as $key => $product) {
            if($product->yupacketTransferBackProductId != null){
                return true;
            }
        }

        return false;
    }
}
