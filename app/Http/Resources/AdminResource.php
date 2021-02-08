<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'level_auth' => $this->level_auth,
            'created_at' => $this->created_at->format('y-m-d h:i a'),
        ];
    }
}
