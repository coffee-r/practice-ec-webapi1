<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (empty($this->productList)){
            return [
                'id' => $this->cartId,
                'userId' => $this->userId,
                'products' => []
            ];
        }

        return [
            'id' => $this->cartId,
            'userId' => $this->userId,
            'products' => CartProductResource::collection($this->productList)
        ];
        
    }
}
