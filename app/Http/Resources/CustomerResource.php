<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name'           => $this->name,
            'tel'            => $this->tel,
            'addr01'         => $this->addr1,
            'addr02'         => $this->addr2,
            'balance_type'   => $this->transaction_type
        ];
    }
}
