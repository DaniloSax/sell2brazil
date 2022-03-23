<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Polyfill\Intl\Idn\Info;

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
        $total_amount_wihtout_discount = $this->products()->get()->reduce(fn ($acum, $item) => $acum += $item->unit_price);

        return [
            'order_id' => $this->order_id,
            'order_code' => $this->order_code,
            'order_date' => $this->order_date,
            'total_amount_wihtout_discount' => $total_amount_wihtout_discount,
            'total_amount_with_discount' => $this->total_amount_with_discount,
            'products' => ProductResource::collection($this->products->unique('article_code'))

        ];
    }
}
