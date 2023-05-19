<?php

use App\Models\GivingType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $values = [
            [
                'name' => 'Купить',
                'slug' => 'buy',
            ],
            [
                'name' => 'Снять',
                'slug' => 'rent',
            ],
        ];

        GivingType::query()->insert($values);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        GivingType::query()->truncate();
    }
};
