<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Characteristic;
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
        $characteristics = [];

        foreach ($this->characteristics as $characteristic) {
            $characteristics["{{{$characteristic->name}}}"] = json_decode($characteristic->pivot->value);
        }

        $values = [
            'id'              => $this->id,
            'title'           => Str::of($this->housingCategory->title)
                ->replace(array_keys($characteristics), array_values($characteristics)),
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
                ->map(function ($characteristic) use ($request) {
                    $characteristicValue = json_decode($characteristic->pivot->value, false);

                    $value = match ($characteristic['type']) {
                        Characteristic::TYPE_ENUM => $characteristic->options
                            ->where('id', $characteristicValue)
                            ->value('name'),
                        Characteristic::TYPE_BOOL => $characteristicValue ? 'Да' : 'Нет',
                        default                   => $this->getFormattedValue(
                            $this->housingCategory->name,
                            $characteristic->name,
                            $characteristicValue,
                        )
                    };

                    return array_merge($characteristic->toArray($request), [
                        'originalValue' => $characteristicValue,
                        'value'         => $value,
                    ]);
                }),
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

        if (is_numeric($characteristicValue) && $characteristicName !== 'year') {
            $characteristicValue = rtrim(number_format($characteristicValue, 2, '.', ' '), '.0');
        }

        if (!$formatted) {
            return $characteristicValue;
        }

        return (string)str_replace('{{value}}', $characteristicValue, $formatted);
    }
}
