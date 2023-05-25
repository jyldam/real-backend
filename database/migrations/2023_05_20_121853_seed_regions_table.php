<?php

use App\Models\Region;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $country = Region::query()->create([
            'name' => 'Казахстан',
        ]);
        $region = Region::query()->create([
            'name'      => 'Павлодаркая область',
            'parent_id' => $country->id,
        ]);
        Region::query()->create([
            'name'      => 'Павлодар',
            'parent_id' => $region->id,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Region::query()->truncate();
    }
};
