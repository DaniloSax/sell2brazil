<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'order_id' => $this->order_id,
            'order_code' => $this->order_code,
            'order_date' => $this->order_date,
            'total_amount_wihtout_discount' => $this->products()->where('user_id', Auth::id())
                ->get()
                ->reduce(fn ($acum, $item) => $acum += $item->unit_price),
            'total_amount_with_discount' => null,
            'products' => ProductResource::collection($this->products->unique('article_code'))

        ];
    }
}
