<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory;
use App\Models\Region;
use App\Models\Housing;
use App\Models\Employee;
use App\Models\GivingType;
use App\Models\HousingAsset;
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
        $faker = Factory::create(config('app.faker_locale'));

        $user = \App\Models\User::factory()->create();
        $employee = Employee::query()->create([
            'user_id'    => $user->id,
            'avatar_url' => '/storage/avatars/58464833.jpg',
            'type'       => Employee::TYPE_ADMIN,
        ]);
        $user2 = \App\Models\User::factory()->create();
        Employee::query()->create([
            'user_id'    => $user2->id,
            'avatar_url' => '/storage/avatars/58464833.jpg',
            'type'       => Employee::TYPE_REALTOR,
        ]);

        $region = Region::query()->create([
            'name' => 'Казахстан',
        ]);
        $region2 = Region::query()->create([
            'name'      => 'Павлодаркая область',
            'parent_id' => $region->id,
        ]);
        Region::query()->create([
            'name'      => 'Павлодар',
            'parent_id' => $region2->id,
        ]);

        $today = today();
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
                'created_at'          => $today,
                'updated_at'          => $today,
            ],
            [
                'name'                => 'О квартире',
                'housing_category_id' => $category->id,
                'parent_id'           => 1,
                'created_at'          => $today,
                'updated_at'          => $today,
            ],
            [
                'name'                => 'Описание',
                'housing_category_id' => $category->id,
                'parent_id'           => null,
                'created_at'          => $today,
                'updated_at'          => $today,
            ],
        ]);

        Characteristic::query()->insert([
            [
                'characteristic_category_id' => 2,
                'name'                       => 'floor',
                'label'                      => 'Этажность',
                'sort'                       => 4,
                'created_at'                 => $today,
                'updated_at'                 => $today,
            ],
            [
                'characteristic_category_id' => 2,
                'name'                       => 'rooms_count',
                'label'                      => 'Комнатность',
                'sort'                       => 0,
                'created_at'                 => $today,
                'updated_at'                 => $today,
            ],
            [
                'characteristic_category_id' => 2,
                'name'                       => 'quadrature',
                'label'                      => 'Площадь',
                'sort'                       => 2,
                'created_at'                 => $today,
                'updated_at'                 => $today,
            ],
            [
                'characteristic_category_id' => 3,
                'name'                       => 'description',
                'label'                      => 'Описание',
                'sort'                       => 0,
                'created_at'                 => $today,
                'updated_at'                 => $today,
            ],
        ]);

        Housing::query()->insert([
            'price'               => 200_000,
            'housing_category_id' => $category->id,
            'employee_id'         => $employee->id,
            'region_id'           => $region->id,
            'address'             => $faker->streetAddress(),
            'giving_type'         => Housing::GIVING_TYPE_RENT,
            'status'              => Housing::STATUS_PUBLISHED,
            'created_at'          => $today,
            'updated_at'          => $today,
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
                'value'             => "\"{$faker->realText(1400)}\"",
            ],
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
