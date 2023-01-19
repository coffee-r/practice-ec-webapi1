<?php

namespace App\Packages\Cart\Domain;

class Product
{
    public readonly ProductId $productId;
    public ProductName $productName;
    public ProductUnitPriceWithTax $productPriceWithTax;
    public ProductUnitTax $productTax;
    public ProductUnitPointPrice $productPointPrice;
    public ProductId | null $yupacketTransferProductId;
    public ProductId | null $yupacketTransferBackProductId;
    public ProductQuantity $productQuantity;

    public function __construct(
        ProductId $productId,
        ProductName $productName,
        ProductUnitPriceWithTax $productPriceWithTax,
        ProductUnitTax $productTax,
        ProductUnitPointPrice $productPointPrice,
        ProductId | null $yupacketTransferProductId,
        ProductId | null $yupacketTransferBackProductId,
        ProductQuantity $productQuantity)
        {
            $this->productId = $productId;
            $this->productName = $productName;
            $this->productPriceWithTax = $productPriceWithTax;
            $this->productTax = $productTax;
            $this->productPointPrice = $productPointPrice;
            $this->yupacketTransferProductId = $yupacketTransferProductId;
            $this->yupacketTransferBackProductId = $yupacketTransferBackProductId;
            $this->productQuantity = $productQuantity;
        }
}
