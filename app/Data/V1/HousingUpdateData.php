<?php

namespace App\Data\V1;

use App\Models\Housing;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use App\Data\V1\HousingCreateData\AssetData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Unique;
use App\Data\V1\HousingCreateData\CharacteristicData;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

#[MapInputName(SnakeCaseMapper::class)]
class HousingUpdateData extends Data
{
    public function __construct(
        #[Exists('housing_categories', 'id')]
        public int $housingCategoryId,

        public int $price,

        #[Exists('regions', 'id')]
        public int $regionId,

        #[Max(1000)]
        public string $address,

        #[Exists('giving_types', 'id')]
        public int $givingType,

        public string $ownerName,

        #[Min(10)]
        #[Max(10)]
        public string $ownerPhone,

        #[Unique('housings', 'contract_number', ignore: new RouteParameterReference('housing', 'id'))]
        public string $contractNumber,

        /** @var DataCollection<CharacteristicData>|null */
        #[DataCollectionOf(CharacteristicData::class)]
        public ?DataCollection $characteristics,

        /** @var DataCollection<AssetData>|null */
        #[DataCollectionOf(AssetData::class)]
        #[Min(3)]
        public ?DataCollection $assets,

        #[In(
            Housing::STATUS_CREATED,
            Housing::STATUS_ON_MODERATION,
            Housing::STATUS_PUBLISHED,
            Housing::STATUS_ARCHIVED,
        )]
        public ?int $status,
    ) {}

    public static function authorize(): bool
    {
        return employee()->isAdmin()
            || employee()->isModerator()
            || request('housing')->employee_id === employee()->id;
    }

    public static function attributes(): array
    {
        return [
            'housing_category_id' => 'категория объявления',
            'price'               => 'цена',
            'region_id'           => 'регион',
            'address'             => 'адрес',
            'giving_type'         => 'тип объявления',
            'status'              => 'статус',
            'owner_name'          => 'имя собственника',
            'owner_phone'         => 'телефон собственника',
            'contract_number'     => 'номер договора',
        ];
    }
}
