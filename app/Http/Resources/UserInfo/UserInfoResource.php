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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'id_verification' => $this->id_verification,
            'created_at' => $this->created_at?->format('F Y'),
        ];
    }
}
