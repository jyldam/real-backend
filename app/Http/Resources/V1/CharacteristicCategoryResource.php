<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacteristicCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $category = [
            'id'              => $this->id,
            'name'            => $this->name,
            'characteristics' => CharacteristicResource::collection($this->characteristics),
        ];

        if ($this->children->isNotEmpty()) {
            $category['children'] = static::collection($this->children);
        }

        return $category;
    }
}
