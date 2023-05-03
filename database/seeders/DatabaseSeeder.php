<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Region;
use App\Models\Housing;
use App\Models\Employee;
use App\Models\GivingType;
use App\Models\Characteristic;
use Illuminate\Database\Seeder;
use App\Models\HousingCategory;
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
            'user_id' => $user->id,
        ]);
        $region = Region::query()->create([
            'name' => 'Алматы',
        ]);
        $today = today();
        $category = HousingCategory::query()->create([
            'name'      => 'Квартиры',
            'mesh_name' => 'квартиры',
            'sort'      => 0,
            'disabled'  => false,
        ]);
        HousingCategory::query()->create([
            'name'      => 'Дома и участки',
            'mesh_name' => 'домов и участков',
            'sort'      => 1,
            'disabled'  => false,
        ]);
        $characteristicCategory = CharacteristicCategory::query()->create([
            'name'                => 'О квартире',
            'housing_category_id' => $category->id,
        ]);
        Characteristic::query()->insert([
            [
                'characteristic_category_id' => $characteristicCategory->id,
                'name'                       => 'floor',
                'label'                      => 'Этажность',
                'sort'                       => 4,
                'created_at'                 => $today,
                'updated_at'                 => $today,
            ],
            [
                'characteristic_category_id' => $characteristicCategory->id,
                'name'                       => 'rooms_count',
                'label'                      => 'Комнатность',
                'sort'                       => 0,
                'created_at'                 => $today,
                'updated_at'                 => $today,
            ],
            [
                'characteristic_category_id' => $characteristicCategory->id,
                'name'                       => 'quadrature',
                'label'                      => 'Площадь',
                'sort'                       => 2,
                'created_at'                 => $today,
                'updated_at'                 => $today,
            ],
            [
                'characteristic_category_id' => $characteristicCategory->id,
                'name'                       => 'address',
                'label'                      => 'Адрес',
                'sort'                       => 3,
                'created_at'                 => $today,
                'updated_at'                 => $today,
            ],
        ]);

        for ($i = 0; $i < 1000; $i++) {
            Housing::query()->insert([
                'price'               => 200_000 + $i,
                'housing_category_id' => $category->id,
                'employee_id'         => $employee->id,
                'region_id'           => $region->id,
                'address'             => $i . $i . 'Test address 137',
                'giving_type'         => Housing::GIVING_TYPE_RENT,
                'status'              => Housing::STATUS_PUBLISHED,
                'created_at'          => $today,
                'updated_at'          => $today,
            ]);
        }

        GivingType::query()->insert([
            [
                'name'       => 'Купить',
                'slug'       => 'buy',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            [
                'name'       => 'Снять',
                'slug'       => 'rent',
                'created_at' => $today,
                'updated_at' => $today,
            ],
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
