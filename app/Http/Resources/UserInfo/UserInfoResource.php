<?php

namespace App\Http\Resources\UserInfo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'created_at' => $this->created_at?->format('F Y'),
        ];
    }
}
