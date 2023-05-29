<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
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
        $values = [
            'id'              => $this->id,
            'title'           => '3-комнатная квартира',
            'assets'          => $this->housingAssets->map(fn($housingAsset) => [
                'id'   => $housingAsset['id'],
                'url'  => asset($housingAsset['url']),
                'type' => $housingAsset['type'],
            ]),
            'price'           => $this->price,
            'address'         => $this->address,
            'region'          => $this->region->name,
            'employee'        => new EmployeeResource($this->employee),
            'category'        => [
                'id'                      => $this->housingCategory->id,
                'name'                    => $this->housingCategory->name,
                'preview_characteristics' => json_decode($this->housingCategory->preview_characteristics),
            ],
            'giving_type'     => $this->givingTypeSlug,
            'characteristics' => CharacteristicResource::collection($this->characteristics)
                ->map(fn($characteristic) => array_merge($characteristic->toArray($request), [
                    'originalValue' => $characteristic['pivot']['value'],
                    'value'         => $this->getFormattedValue(
                        $this->housingCategory->name,
                        $characteristic['name'],
                        $characteristic['pivot']['value'],
                    ),
                ])),
            'created_at'      => Carbon::parse($this->created_at)->format('d.m.Y H:i'),
            'status'          => $this->status,
        ];

        if (employee()) {
            $values['owner'] = [
                'phone' => $this->owner_phone,
                'name'  => $this->owner_name,
            ];
            $values['contract_number'] = $this->contract_number;
        }

        return $values;
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
