<?php

namespace App\Data\V1;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use App\Data\V1\HousingCreateData\AssetData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Unique;
use App\Data\V1\HousingCreateData\CharacteristicData;

#[MapInputName(SnakeCaseMapper::class)]
class HousingCreateData extends Data
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

        /** @var DataCollection<AssetData> */
        #[DataCollectionOf(AssetData::class)]
        #[Min(3)]
        public DataCollection $assets,

        public string $ownerName,

        #[Min(10)]
        #[Max(10)]
        public string $ownerPhone,

        #[Unique('housings', 'contract_number')]
        public string $contractNumber,

        /** @var DataCollection<CharacteristicData> */
        #[DataCollectionOf(CharacteristicData::class)]
        public ?DataCollection $characteristics,

        public ?bool $moderate,

        #[Exists('employees', 'id')]
        public ?int $employeeId = null,
    ) {}

    public static function authorize(): bool
    {
        return employee() && (employee()->isAdmin() || employee()->isRealtor());
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
            'characteristics'     => 'характеристики',
            'assets'              => 'изображения',
            'owner_name'          => 'имя собственника',
            'owner_phone'         => 'телефон собственника',
            'contract_number'     => 'номер договора',
        ];
    }
}
