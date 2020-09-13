<?php

namespace App\Http\Resources\Base\V1;

class UserResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'user_name'   => $this->user_name,
            'email'      => $this->email,
        ];
    }
}
