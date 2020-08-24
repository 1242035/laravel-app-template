<?php

namespace App\Http\Resources\Base\V1;

class RoleResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'name' => $this->name
        ];
    }
}
