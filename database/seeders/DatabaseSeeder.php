<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Housing;
use App\Models\HousingAsset;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use App\Data\V1\HousingCreateData;
use App\Services\V1\HousingService;
use App\Data\V1\HousingReportCreateData;
use App\Services\V1\HousingReportService;
use App\Data\V1\HousingCreateData\AssetData;
use App\Data\V1\HousingCreateData\CharacteristicData;

class DatabaseSeeder extends Seeder
{
    public function __construct(
        private readonly HousingService $housingService,
        private readonly HousingReportService $housingReportService,
    ) {}

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->housingService->create(new HousingCreateData(
            housingCategoryId: 1,
            price: 200_000,
            regionId: 1,
            address: fake()->streetAddress(),
            givingType: 1,
            assets: AssetData::collection(items: [
                new AssetData(
                    type: HousingAsset::TYPE_REGULAR_IMAGE,
                    file: UploadedFile::fake()->image('asset.jpg'),
                ),
            ]),
            ownerName: fake()->name(),
            ownerPhone: '7778884422',
            contractNumber: '0001',
            characteristics: CharacteristicData::collection(items: [
                new CharacteristicData(characteristicId: 1, value: 1),
                new CharacteristicData(characteristicId: 2, value: 1),
                new CharacteristicData(characteristicId: 3, value: 5),
                new CharacteristicData(characteristicId: 4, value: 13),
                new CharacteristicData(characteristicId: 5, value: 40),
                new CharacteristicData(characteristicId: 6, value: 10),
                new CharacteristicData(characteristicId: 7, value: 2021),
                new CharacteristicData(characteristicId: 8, value: 'test'),
            ]),
            moderate: true,
            employeeId: 1
        ));

        Housing::where('id', 1)->update([
            'status' => Housing::STATUS_PUBLISHED,
        ]);

        $this->housingReportService->create(new HousingReportCreateData(
            type: 1,
            housingId: 1,
            fields: [
                'message' => fake()->realText(),
            ]
        ));
    }
}
