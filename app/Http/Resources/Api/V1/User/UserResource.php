<?php

namespace App\Http\Resources\Api\V1\User;

class UserResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => $this->customer
        ];
    }
}
