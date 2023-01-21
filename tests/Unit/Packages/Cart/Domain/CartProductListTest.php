<?php

namespace Tests\Unit\Packages\Cart\Domain;

use App\Packages\Cart\Domain\CartProduct;
use App\Packages\Cart\Domain\CartProductList;
use App\Packages\Cart\Domain\ProductId;
use App\Packages\Cart\Domain\ProductName;
use App\Packages\Cart\Domain\ProductQuantity;
use App\Packages\Cart\Domain\ProductUnitPointPrice;
use App\Packages\Cart\Domain\ProductUnitPriceWithTax;
use App\Packages\Cart\Domain\ProductUnitTax;
use App\Packages\Shared\Domain\DomainException;
use PHPUnit\Framework\TestCase;

class CartProductListTest extends TestCase
{
    public function test_商品配列以外の配列でインスタンス化()
    {
        $cartProducts = [
            '商品1', '商品2', '商品3'
        ];

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('商品リストには商品のみを入れられます');
        $cartProductList = new CartProductList($cartProducts);
    }

    public function test_商品の追加()
    {
        $cartProductList = new CartProductList([]);

        $addCartProduct1 = new CartProduct(
            new ProductId(1),
            new ProductName('商品1'),
            new ProductUnitPriceWithTax(100),
            new ProductUnitTax(10),
            new ProductUnitPointPrice(0),
            new ProductQuantity(1)
        );

        $addCartProduct2 = new CartProduct(
            new ProductId(2),
            new ProductName('商品2'),
            new ProductUnitPriceWithTax(200),
            new ProductUnitTax(20),
            new ProductUnitPointPrice(0),
            new ProductQuantity(1)
        );

        $addCartProduct3 = new CartProduct(
            new ProductId(2),
            new ProductName('商品2'),
            new ProductUnitPriceWithTax(200),
            new ProductUnitTax(20),
            new ProductUnitPointPrice(0),
            new ProductQuantity(2)
        );

        $cartProductList = $cartProductList->add($addCartProduct1);
        $cartProductList = $cartProductList->add($addCartProduct2);
        $cartProductList = $cartProductList->add($addCartProduct3);
        
        // 商品の種類数
        $this->assertEquals(2, count($cartProductList->value));

        // 商品の数量
        $this->assertEquals(1, $cartProductList->value[0]->productQuantity->value);
        $this->assertEquals(3, $cartProductList->value[1]->productQuantity->value);
    }

    public function test_商品の削除()
    {
        $addCartProduct1 = new CartProduct(
            new ProductId(1),
            new ProductName('商品1'),
            new ProductUnitPriceWithTax(100),
            new ProductUnitTax(10),
            new ProductUnitPointPrice(0),
            new ProductQuantity(1)
        );

        $addCartProduct2 = new CartProduct(
            new ProductId(2),
            new ProductName('商品2'),
            new ProductUnitPriceWithTax(200),
            new ProductUnitTax(20),
            new ProductUnitPointPrice(0),
            new ProductQuantity(1)
        );

        $cartProductList = new CartProductList([$addCartProduct1, $addCartProduct2]);

        $cartProductList = $cartProductList->remove($addCartProduct2->productId);

        $this->assertEquals(1, count($cartProductList->value));
    }
}