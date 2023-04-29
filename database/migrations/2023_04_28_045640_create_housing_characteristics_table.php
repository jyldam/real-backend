<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('housing_characteristics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Characteristic::class)
                ->constrained();
            $table->foreignIdFor(\App\Models\Housing::class)
                ->constrained();
            $table->json('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_characteristics');
    }
};
