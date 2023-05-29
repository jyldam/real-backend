<?php

use App\Models\HousingCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Aparts
        $aparts = HousingCategory::query()->create([
            'name' => 'Квартиры',
            'mesh_name' => 'квартиру',
            'disabled' => false,
            'sort' => 0,
            'preview_characteristics' => ['rooms_count', 'quadrature', 'floor'],
        ]);
        $apartsCharacteristics = $aparts->characteristicCategories()->create([
            'name' => 'Характеристики',
        ]);
        $apartsCharacteristics->characteristics()->createMany([
            [
                'name' => 'rooms_count',
                'label' => 'Количество комнат',
                'sort' => 0,
            ],
            [
                'name' => 'floor',
                'label' => 'Этажность',
                'sort' => 1,
            ],
            [
                'name' => 'quadrature',
                'label' => 'Площадь',
                'sort' => 2,
            ],
            [
                'name' => 'year',
                'label' => 'Год постройки',
                'sort' => 3,
            ],
        ]);
        $aparts->characteristicCategories()->create([
            'name' => 'Описание',
        ])->characteristics()->create([
            'name' => 'description',
            'label' => 'Описание',
            'sort' => 0,
        ]);

        // House
        $house = HousingCategory::query()->create([
            'name' => 'Дома',
            'mesh_name' => 'дом',
            'disabled' => false,
            'sort' => 1,
            'preview_characteristics' => ['type', 'size', 'quadrature', 'floor'],
        ]);
        $houseCharacteristics = $house->characteristicCategories()->create([
            'name' => 'Характеристики',
        ]);
        $houseCharacteristics->characteristics()->createMany([
            [
                'name' => 'rooms_count',
                'label' => 'Количество комнат',
                'sort' => 0,
            ],
            [
                'name' => 'floor',
                'label' => 'Этажность',
                'sort' => 1,
            ],
            [
                'name' => 'quadrature',
                'label' => 'Площадь дома',
                'sort' => 2,
            ],
            [
                'name' => 'year',
                'label' => 'Год постройки',
                'sort' => 3,
            ],
        ]);
        $house->characteristicCategories()->create([
            'name' => 'Описание',
        ])->characteristics()->create([
            'name' => 'description',
            'label' => 'Описание',
            'sort' => 0,
        ]);

        // Stock
        $stock = HousingCategory::query()->create([
            'name' => 'Прочая недвижимость',
            'mesh_name' => 'прочей недвижимости',
            'disabled' => false,
            'sort' => 2,
            'preview_characteristics' => [],
        ]);
        $stockCharacteristics = $stock->characteristicCategories()->create([
            'name' => 'Характеристики',
        ]);
        $stockCharacteristics->characteristics()->createMany([
            [
                'name' => 'rooms_count',
                'label' => 'Количество комнат',
                'sort' => 0,
            ],
            [
                'name' => 'floor',
                'label' => 'Этажность',
                'sort' => 1,
            ],
            [
                'name' => 'land_quadrature',
                'label' => 'Площадь территории',
                'sort' => 2,
            ],
            [
                'name' => 'room_quadrature',
                'label' => 'Площадь производственных помещений',
                'sort' => 3,
            ],
            [
                'name' => 'room_height',
                'label' => 'Высота производственных помещений',
                'sort' => 4,
            ],
            [
                'name' => 'year',
                'label' => 'Год постройки',
                'sort' => 5,
            ],
        ]);
        $stock->characteristicCategories()->create([
            'name' => 'Описание',
        ])->characteristics()->create([
            'name' => 'description',
            'label' => 'Описание',
            'sort' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        HousingCategory::truncate();
    }
};
