<?php

namespace App\Packages\Product\Domain;

use App\Packages\Catalog\Domain\Product;
use App\Packages\Shared\Domain\DomainException;

class ProductList
{
    public readonly array $value;

    public function __construct(array $value)
    {
        if (count($value) == 0) {
            $this->value = [];
            return;
        }

        foreach ($value as $key => $product) {
            if (($product instanceof Product) == false) {
                throw new DomainException('商品リストには商品のみを入れられます');
            }
        }
        $this->value = $value;
    }
}