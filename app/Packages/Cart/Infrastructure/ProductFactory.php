<?php

namespace App\Packages\Cart\Infrastructure;

use App\Models\Product as ModelsProduct;
use App\Packages\Cart\Domain\Product;
use App\Packages\Cart\Domain\ProductFactoryInterface;
use App\Packages\Cart\Domain\ProductId;
use App\Packages\Cart\Domain\ProductName;
use App\Packages\Cart\Domain\ProductQuantity;
use App\Packages\Cart\Domain\ProductUnitPointPrice;
use App\Packages\Cart\Domain\ProductUnitPriceWithTax;
use App\Packages\Cart\Domain\ProductUnitTax;
use App\Packages\Shared\Infrastructure\InfrastructureException;

class ProductFactory implements ProductFactoryInterface
{
    public function create(ProductId $productId, ProductQuantity $productQuantity) : Product
    {
        $modelProduct = ModelsProduct::find($productId->value);

        if(empty($modelProduct)){
            throw new InfrastructureException('商品が見つかりませんでした');
        }

        return new Product(
            $productId,
            new ProductName($modelProduct->name),
            new ProductUnitPriceWithTax($modelProduct->price_with_tax),
            new ProductUnitTax($modelProduct->tax),
            new ProductUnitPointPrice($modelProduct->point_price),
            $productQuantity
        );
    }
}