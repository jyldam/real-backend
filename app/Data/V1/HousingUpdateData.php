<?php

namespace App\Data\V1;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use App\Data\V1\HousingCreateData\AssetData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Exists;
use App\Data\V1\HousingCreateData\CharacteristicData;
use Spatie\LaravelData\Attributes\Validation\Sometimes;

#[MapInputName(SnakeCaseMapper::class)]
class HousingUpdateData extends Data
{
    public function __construct(
        #[Exists('housing_categories', 'id')]
        public int             $housingCategoryId,

        public int             $price,

        #[Exists('regions', 'id')]
        public int             $regionId,

        #[Max(1000)]
        public string          $address,

        #[Exists('giving_types', 'id')]
        public int             $givingType,

        /** @var DataCollection<CharacteristicData>|null */
        #[DataCollectionOf(CharacteristicData::class)]
        public ?DataCollection $characteristics,

        /** @var DataCollection<AssetData>|null */
        #[DataCollectionOf(AssetData::class)]
        public ?DataCollection $assets,

        #[Sometimes]
        public ?bool           $moderate,
    ) {}

    public static function authorize(): bool
    {
        $employee = employee();
        return $employee->isAdmin()
            || $employee->isModerator()
            || request('housing')->employee_id === $employee->id;
    }

    public static function attributes(): array
    {
        return [
            'housing_category_id' => 'категория объявления',
            'price'               => 'цена',
            'region_id'           => 'регион',
            'address'             => 'адрес',
            'giving_type'         => 'тип объявления',
            'moderate'            => 'на модерацию',
        ];
    }
}
