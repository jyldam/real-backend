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
        Schema::create('housing_filters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(HousingCategory::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->integer('type');
            $table->string('label', 50);
            $table->string('field', 50);
            $table->string('relation', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_filters');
    }
};
