<?php

use App\Models\HousingCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        HousingCategory::query()
            ->where('name', 'Квартиры')
            ->update([
                'mesh_name' => 'квартир',
            ]);
        HousingCategory::query()
            ->where('name', 'Дома')
            ->update([
                'mesh_name' => 'домов',
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        HousingCategory::query()
            ->where('name', 'Квартиры')
            ->update([
                'mesh_name' => 'квартиру',
            ]);
        HousingCategory::query()
            ->where('name', 'Дома')
            ->update([
                'mesh_name' => 'дом',
            ]);
    }
};
