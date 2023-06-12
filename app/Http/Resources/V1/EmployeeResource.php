<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'avatar_url' => asset($this->avatar_url),
            'phone'      => $this->user->phone,
            'name'       => $this->user->name,
            'email'      => $this->user->email,
            'type'       => $this->type,
        ];
    }
}
