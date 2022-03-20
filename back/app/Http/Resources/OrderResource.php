<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->article_code,
            'order_code' => $this->article_name,
            'order_date' => $this->unit_price,
            'total_amount_wihtout_discount' => Product::all()->filter(fn ($product) => $product->article_code === $product->article_code),
            'total_amount_with_discount' => $this->unit_price

        ];
    }
}
