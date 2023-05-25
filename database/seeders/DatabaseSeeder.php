<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Housing;
use App\Models\Employee;
use App\Models\HousingAsset;
use App\Models\HousingReport;
use App\Models\Characteristic;
use Illuminate\Database\Seeder;
use App\Models\HousingCategory;
use Illuminate\Support\Facades\DB;
use App\Models\CharacteristicCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create();
        $employee = Employee::query()->create([
            'user_id'    => $user->id,
            'avatar_url' => '/storage/avatars/58464833.jpg',
            'type'       => Employee::TYPE_ADMIN,
        ]);

        for ($i = 0; $i < 1000; $i++) {
            $user = \App\Models\User::factory()->create();
            Employee::query()->create([
                'user_id'    => $user->id,
                'avatar_url' => '/storage/avatars/58464833.jpg',
                'type'       => Employee::TYPE_REALTOR,
            ]);
        }

        $now = now();
        $category = HousingCategory::query()->create([
            'name'                    => 'Квартиры',
            'mesh_name'               => 'квартиры',
            'sort'                    => 0,
            'disabled'                => false,
            'preview_characteristics' => json_encode(['rooms_count', 'quadrature', 'floor']),
        ]);
        HousingCategory::query()->create([
            'name'                    => 'Дома и участки',
            'mesh_name'               => 'домов и участков',
            'sort'                    => 1,
            'disabled'                => false,
            'preview_characteristics' => json_encode(['rooms_count', 'quadrature']),
        ]);

        CharacteristicCategory::query()->insert([
            [
                'name'                => 'Характеристики',
                'housing_category_id' => $category->id,
                'parent_id'           => null,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'name'                => 'О квартире',
                'housing_category_id' => $category->id,
                'parent_id'           => 1,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'name'                => 'Описание',
                'housing_category_id' => $category->id,
                'parent_id'           => null,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
        ]);

        Characteristic::query()->insert([
            [
                'characteristic_category_id' => 2,
                'name'                       => 'floor',
                'label'                      => 'Этажность',
                'sort'                       => 4,
                'created_at'                 => $now,
                'updated_at'                 => $now,
            ],
            [
                'characteristic_category_id' => 2,
                'name'                       => 'rooms_count',
                'label'                      => 'Комнатность',
                'sort'                       => 0,
                'created_at'                 => $now,
                'updated_at'                 => $now,
            ],
            [
                'characteristic_category_id' => 2,
                'name'                       => 'quadrature',
                'label'                      => 'Площадь',
                'sort'                       => 2,
                'created_at'                 => $now,
                'updated_at'                 => $now,
            ],
            [
                'characteristic_category_id' => 3,
                'name'                       => 'description',
                'label'                      => 'Описание',
                'sort'                       => 0,
                'created_at'                 => $now,
                'updated_at'                 => $now,
            ],
        ]);

        Housing::query()->insert([
            'price'               => 200_000,
            'housing_category_id' => $category->id,
            'employee_id'         => $employee->id,
            'region_id'           => 3,
            'address'             => fake()->streetAddress(),
            'giving_type'         => 1,
            'status'              => Housing::STATUS_PUBLISHED,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        HousingAsset::query()->insert([
            [
                'housing_id' => 1,
                'url'        => '/storage/housing-asset/1.jpg',
                'type'       => HousingAsset::TYPE_REGULAR_IMAGE,
            ],
            [
                'housing_id' => 1,
                'url'        => '/storage/housing-asset/2.jpg',
                'type'       => HousingAsset::TYPE_REGULAR_IMAGE,
            ],
            [
                'housing_id' => 1,
                'url'        => '/storage/housing-asset/3.jpg',
                'type'       => HousingAsset::TYPE_REGULAR_IMAGE,
            ],
        ]);

        DB::table('housing_characteristics')->insert([
            [
                'characteristic_id' => 1,
                'housing_id'        => 1,
                'value'             => 5,
            ],
            [
                'characteristic_id' => 2,
                'housing_id'        => 1,
                'value'             => 3,
            ],
            [
                'characteristic_id' => 3,
                'housing_id'        => 1,
                'value'             => 40,
            ],
            [
                'characteristic_id' => 4,
                'housing_id'        => 1,
                'value'             => '"' . fake()->realText(1400) . '"',
            ],
        ]);

        for ($i = 0; $i < 100; $i++) {
            HousingReport::query()
                ->insert([
                    'housing_report_type_id' => random_int(1, 13),
                    'housing_id'             => 1,
                    'value'                  => json_encode([
                        'message' => fake()->realText(),
                    ]),
                    'created_at'             => $now,
                    'updated_at'             => $now,
                    'status'                 => HousingReport::STATUS_CREATED,
                ]);
        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
