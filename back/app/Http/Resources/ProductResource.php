<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $quantity = Product::where('article_code', $this->article_code)->get()->count();

        return [
            'articleCode' => $this->article_code,
            'articleName' => $this->article_name,
            'articleDescription' => $this->article_description,
            'image' => $this->images->first()->path,
            'unitPrice' => $this->unit_price,
            'quantity' => $quantity,
        ];
    }
}
