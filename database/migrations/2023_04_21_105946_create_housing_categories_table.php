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
        Schema::create('housing_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('mesh_name', 30);
            $table->string('title', 255);
            $table->boolean('disabled')->index();
            $table->integer('sort');
            $table->json('preview_characteristics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_categories');
    }
};
