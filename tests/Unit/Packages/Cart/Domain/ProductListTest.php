<?php

namespace Tests\Unit\Packages\Cart\Domain;

use App\Packages\Cart\Domain\Product;
use App\Packages\Cart\Domain\ProductId;
use App\Packages\Cart\Domain\ProductList;
use App\Packages\Cart\Domain\ProductName;
use App\Packages\Cart\Domain\ProductQuantity;
use App\Packages\Cart\Domain\ProductUnitPointPrice;
use App\Packages\Cart\Domain\ProductUnitPriceWithTax;
use App\Packages\Cart\Domain\ProductUnitTax;
use App\Packages\Shared\Domain\DomainException;
use PHPUnit\Framework\TestCase;

class ProductListTest extends TestCase
{
    public function test_商品配列以外の配列でインスタンス化()
    {
        $products = [
            '商品1', '商品2', '商品3'
        ];

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('商品リストには商品のみを入れられます');
        $productList = new ProductList($products);
    }

    public function test_商品の追加()
    {
        $productList = new ProductList([]);

        $addProduct1 = new Product(
            new ProductId(1),
            new ProductName('商品1'),
            new ProductUnitPriceWithTax(100),
            new ProductUnitTax(10),
            new ProductUnitPointPrice(0),
            new ProductQuantity(1)
        );

        $addProduct2 = new Product(
            new ProductId(2),
            new ProductName('商品2'),
            new ProductUnitPriceWithTax(200),
            new ProductUnitTax(20),
            new ProductUnitPointPrice(0),
            new ProductQuantity(1)
        );

        $addProduct3 = new Product(
            new ProductId(2),
            new ProductName('商品2'),
            new ProductUnitPriceWithTax(200),
            new ProductUnitTax(20),
            new ProductUnitPointPrice(0),
            new ProductQuantity(2)
        );

        $productList = $productList->add($addProduct1);
        $productList = $productList->add($addProduct2);
        $productList = $productList->add($addProduct3);
        
        // 商品の種類数
        $this->assertEquals(2, count($productList->value));

        // 商品の数量
        $this->assertEquals(1, $productList->value[0]->productQuantity->value);
        $this->assertEquals(3, $productList->value[1]->productQuantity->value);
    }

    public function test_商品の削除()
    {
        $addProduct1 = new Product(
            new ProductId(1),
            new ProductName('商品1'),
            new ProductUnitPriceWithTax(100),
            new ProductUnitTax(10),
            new ProductUnitPointPrice(0),
            new ProductQuantity(1)
        );

        $addProduct2 = new Product(
            new ProductId(2),
            new ProductName('商品2'),
            new ProductUnitPriceWithTax(200),
            new ProductUnitTax(20),
            new ProductUnitPointPrice(0),
            new ProductQuantity(1)
        );

        $productList = new ProductList([$addProduct1, $addProduct2]);

        $productList = $productList->remove($addProduct2->productId);

        $this->assertEquals(1, count($productList->value));
    }
}