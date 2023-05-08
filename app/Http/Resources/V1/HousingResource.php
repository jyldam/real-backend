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
            'id'              => $this->id,
            'title'           => '3-комнатная квартира',
            'images'          => [
                'https://images.unsplash.com/photo-1580757468214-c73f7062a5cb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8MTYlM0E5fGVufDB8fDB8fA%3D%3D&w=1000&q=80',
                'https://images.unsplash.com/photo-1558637845-c8b7ead71a3e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8M3x8MTYlM0E5fGVufDB8fDB8fA%3D%3D&w=1000&q=80',
                'https://images.unsplash.com/photo-1603486002664-a7319421e133?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8MTYlM0E5fGVufDB8fDB8fA%3D%3D&w=1000&q=80',
            ],
            'price'           => $this->price,
            'address'         => $this->address,
            'region'          => $this->region->name,
            'employee'        => [
                'name'  => $this->employee->user->name,
                'image' => asset($this->employee->avatar_url),
                'phone' => $this->employee->user->phone,
            ],
            'category'        => [
                'id'                      => $this->housingCategory->id,
                'name'                    => $this->housingCategory->name,
                'preview_characteristics' => $this->housingCategory->preview_characteristics,
            ],
            'giving_type'     => $this->givingTypeSlug?->slug,
            'characteristics' => CharacteristicResource::collection($this->characteristics)
                ->map(fn($characteristic) => array_merge($characteristic->toArray($request), [
                    'originalValue' => $characteristic['pivot']['value'],
                    'value'         => $this->getFormattedValue(
                        $this->housingCategory->name,
                        $characteristic['name'],
                        $characteristic['pivot']['value']
                    ),
                ])),
        ];
    }

    private function getFormattedValue($categoryName, $characteristicName, $characteristicValue)
    {
        $formatted = @config('formatted-values')[mb_strtolower($categoryName)][strtolower($characteristicName)];
        $characteristicValue = json_decode($characteristicValue);

        if (is_numeric($characteristicValue)) {
            $characteristicValue = number_format($characteristicValue, 0, '.', ' ');
        }

        if (!$formatted) {
            return $characteristicValue;
        }

        return (string)str_replace('{{value}}', $characteristicValue, $formatted);
    }
}
