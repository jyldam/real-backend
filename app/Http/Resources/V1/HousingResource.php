<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HousingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'images'   => [
                'https://images.unsplash.com/photo-1580757468214-c73f7062a5cb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8MTYlM0E5fGVufDB8fDB8fA%3D%3D&w=1000&q=80',
                'https://images.unsplash.com/photo-1558637845-c8b7ead71a3e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8M3x8MTYlM0E5fGVufDB8fDB8fA%3D%3D&w=1000&q=80',
                'https://images.unsplash.com/photo-1603486002664-a7319421e133?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8MTYlM0E5fGVufDB8fDB8fA%3D%3D&w=1000&q=80',
            ],
            'price'    => $this->price,
            'address'  => $this->address,
            'region'   => $this->region->name,
            'employee' => [
                'name'  => $this->employee->user->name,
                'image' => 'https://cdn.esoft.digital/240320/cluster/profiles/df/f73c85f35646a294dd4bcc7078c0e3174e4b62df.jpeg',
                'phone' => $this->employee->user->phone,
            ],
            'category' => $this->housingCategory->name,
        ];
    }
}
