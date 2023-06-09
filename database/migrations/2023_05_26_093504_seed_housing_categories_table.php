<?php

use App\Models\Characteristic;
use App\Models\HousingCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Aparts
        $aparts = HousingCategory::query()
            ->create([
                'name'                    => 'Квартиры',
                'mesh_name'               => 'квартиру',
                'disabled'                => false,
                'sort'                    => 0,
                'preview_characteristics' => [
                    'rooms_count',
                    'quadrature',
                    'floor',
                ],
            ]);

        $characteristics = $aparts->characteristicCategories()->create([
            'name' => 'Характеристики',
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'rooms_count',
            'label'    => 'Количество комнат',
            'sort'     => 0,
            'type'     => Characteristic::TYPE_NUMBER,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'building_type',
            'label'    => 'Тип строения',
            'sort'     => 1,
            'type'     => Characteristic::TYPE_ENUM,
            'required' => true,
        ])->options()->createMany([
            ['name' => 'Кирпичный'],
            ['name' => 'Панельный'],
            ['name' => 'Монолитный'],
            ['name' => 'Иное'],
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'floor',
            'label'    => 'Этаж',
            'sort'     => 2,
            'type'     => Characteristic::TYPE_NUMBER,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'total_floor',
            'label'    => 'Этажность',
            'sort'     => 3,
            'type'     => Characteristic::TYPE_NUMBER,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'total_quadrature',
            'label'    => 'Квадратура общая',
            'sort'     => 4,
            'type'     => Characteristic::TYPE_NUMBER,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'kitchen_quadrature',
            'label'    => 'Квадратура кухня',
            'sort'     => 5,
            'type'     => Characteristic::TYPE_NUMBER,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'year',
            'label'    => 'Год постройки',
            'sort'     => 6,
            'type'     => Characteristic::TYPE_NUMBER,
            'required' => true,
        ]);

        $aparts->characteristicCategories()->create([
            'name' => 'Описание',
        ])->characteristics()->create([
            'name'     => 'description',
            'label'    => 'Описание',
            'sort'     => 0,
            'type'     => Characteristic::TYPE_STRING,
            'required' => true,
        ]);

        // House
        $house = HousingCategory::query()->create([
            'name'                    => 'Дома',
            'mesh_name'               => 'дом',
            'disabled'                => false,
            'sort'                    => 1,
            'preview_characteristics' => [
                'type',
                'size',
                'quadrature',
                'floor',
            ],
        ]);

        $characteristics = $house->characteristicCategories()->create([
            'name' => 'Характеристики',
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'square',
            'label'    => 'Площадь участка, соток',
            'sort'     => 0,
            'type'     => Characteristic::TYPE_NUMBER,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'heating',
            'label'    => 'Отопление',
            'sort'     => 1,
            'type'     => Characteristic::TYPE_ENUM,
            'required' => true,
        ])->options()->createMany([
            ['name' => 'Центральное'],
            ['name' => 'На газе'],
            ['name' => 'На твердом топливе'],
            ['name' => 'На жидком топливе'],
            ['name' => 'Смешанное'],
            ['name' => 'Без отопления'],
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'water',
            'label'    => 'Вода',
            'sort'     => 2,
            'type'     => Characteristic::TYPE_ENUM,
            'required' => true,
        ])->options()->createMany([
            ['name' => 'Центральное водоснабжение'],
            ['name' => 'Есть возможность подключения'],
            ['name' => 'Скважина'],
            ['name' => 'Нет'],
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'sewerage',
            'label'    => 'Канализация',
            'sort'     => 3,
            'type'     => Characteristic::TYPE_ENUM,
            'required' => true,
        ])->options()->createMany([
            ['name' => 'Центральная'],
            ['name' => 'Есть возможность подведения'],
            ['name' => 'Септик'],
            ['name' => 'Нет'],
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'quadrature',
            'label'    => 'Квадратура дома',
            'sort'     => 4,
            'type'     => Characteristic::TYPE_NUMBER,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'number_of_floors',
            'label'    => 'Количество этажей',
            'sort'     => 5,
            'type'     => Characteristic::TYPE_NUMBER,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'building_type',
            'label'    => 'Тип строения',
            'sort'     => 6,
            'type'     => Characteristic::TYPE_ENUM,
            'required' => true,
        ])->options()->createMany([
            ['name' => 'кирпичный'],
            ['name' => 'панельный'],
            ['name' => 'монолитный'],
            ['name' => 'деревянный'],
            ['name' => 'каркасно-камышитовый'],
            ['name' => 'пеноблочный'],
            ['name' => 'сэндвич-панели'],
            ['name' => 'каркасно-щитовой'],
            ['name' => 'шлакоблочный'],
            ['name' => 'иное'],
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'garage',
            'label'    => 'Гараж',
            'sort'     => 7,
            'type'     => Characteristic::TYPE_BOOL,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'bath',
            'label'    => 'Баня',
            'sort'     => 8,
            'type'     => Characteristic::TYPE_BOOL,
            'required' => true,
        ]);

        $characteristics->characteristics()->create([
            'name'     => 'outbuildings',
            'label'    => 'Хозпостройки',
            'sort'     => 9,
            'type'     => Characteristic::TYPE_BOOL,
            'required' => true,
        ]);

        $house->characteristicCategories()->create([
            'name' => 'Описание',
        ])->characteristics()->create([
            'name'     => 'description',
            'label'    => 'Описание',
            'sort'     => 0,
            'type'     => Characteristic::TYPE_STRING,
            'required' => true,
        ]);

        // Other
        $other = HousingCategory::query()->create([
            'name'                    => 'Прочая недвижимость',
            'mesh_name'               => 'прочей недвижимости',
            'disabled'                => false,
            'sort'                    => 2,
            'preview_characteristics' => [],
        ]);

        $characteristics = $other->characteristicCategories()->create([
            'name' => 'Характеристики',
        ]);

        $other->characteristicCategories()->create([
            'name' => 'Описание',
        ])->characteristics()->create([
            'name'     => 'description',
            'label'    => 'Описание',
            'sort'     => 0,
            'type'     => Characteristic::TYPE_STRING,
            'required' => true,
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
