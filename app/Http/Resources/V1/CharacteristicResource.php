<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacteristicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $characteristic = [
            'id'       => $this->id,
            'name'     => $this->name,
            'label'    => $this->label,
            'type'     => $this->type,
            'required' => $this->required,
        ];

        if ($this->options->isNotEmpty()) {
            $characteristic['options'] = $this->options->map->only([
                'id',
                'name',
            ]);
        }

        return $characteristic;
    }
}
