<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StorageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'arrival_date' => $this->arrival_date->format('Y-m-d'),
            'market_name' => $this->market->market_name,
            'product_name' => $this->product->name,
            'category_name' => $this->category->category_name,
            'supplier_name' => $this->supplier->name,
            'total_quantity' => $this->total_quantity,
            'total_price' => $this->total_price,
            'note' => $this->note,
            'plan_delivery_day' => $this->plan_delivery_day,
            'image' => $this->image_resize,
            'tax' => $this->tax,
        ];
    }
}
