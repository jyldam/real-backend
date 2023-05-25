<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HousingCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'name'                    => $this->name,
            'mesh_name'               => $this->mesh_name,
            'preview_characteristics' => $this->preview_characteristics,
            'characteristics'         => $this->characteristicCategories
                ->flatMap
                ->characteristics
                ->map
                ->only(['id', 'label', 'name']),
            'housings'                => HousingResource::collection($this->housings),
        ];
    }
}
