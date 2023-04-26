<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Region;
use App\Models\Housing;
use App\Models\Employee;
use Illuminate\Database\Seeder;

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

        Housing::query()->insert([
            [
                'price'       => 200_000,
                'employee_id' => $employee->id,
                'region_id'   => $region->id,
                'address'     => 'Test address 137',
                'giving_type' => Housing::GIVING_TYPE_RENT,
                'status'      => Housing::STATUS_PUBLISHED,
                'created_at'  => $today,
                'updated_at'  => $today,
            ],
            [
                'price'       => 250_000,
                'employee_id' => $employee->id,
                'region_id'   => $region->id,
                'address'     => 'Test address 12',
                'giving_type' => Housing::GIVING_TYPE_RENT,
                'status'      => Housing::STATUS_PUBLISHED,
                'created_at'  => $today,
                'updated_at'  => $today,
            ],
            [
                'price'       => 300_000,
                'employee_id' => $employee->id,
                'region_id'   => $region->id,
                'address'     => 'Test address 99',
                'giving_type' => Housing::GIVING_TYPE_RENT,
                'status'      => Housing::STATUS_PUBLISHED,
                'created_at'  => $today,
                'updated_at'  => $today,
            ],
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
