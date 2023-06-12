<?php

use Illuminate\Support\Facades\Schema;
use App\Models\CharacteristicCategory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('characteristics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CharacteristicCategory::class)
                ->constrained();
            $table->string('name', 50);
            $table->string('label', 50);
            $table->integer('type');
            $table->boolean('multiple')->nullable();
            $table->boolean('required');
            $table->integer('sort')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characteristics');
    }
};
