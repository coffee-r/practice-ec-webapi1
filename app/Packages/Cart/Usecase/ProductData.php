<?php

namespace App\Packages\Cart\Usecase;

use App\Packages\Cart\Domain\Product;

class ProductData
{
    public readonly int $productId;
    public readonly string $productName;
    public readonly int $productPriceWithTax;
    public readonly int $productTax;
    public readonly int $productPointPrice;
    public readonly int | null $yupacketTransferProductId;
    public readonly int | null $yupacketTransferBackProductId;
    public readonly int $productQuantity;

    public function __construct(Product $product)
    {
        $this->productId = $product->productId->value;
        $this->productName = $product->productName->value;
        $this->productPriceWithTax = $product->productPriceWithTax->value;
        $this->productTax = $product->productTax->value;
        $this->productPointPrice = $product->productPointPrice->value;
        $this->yupacketTransferProductId = $product->yupacketTransferProductId->value;
        $this->yupacketTransferBackProductId = $product->yupacketTransferBackProductId->value;
        $this->productQuantity = $product->productQuantity->value;        
    }
}