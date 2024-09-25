<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('model_id');
            $table->string('model_name', 250);
            $table->json('before')->nullable();
            $table->json('after')->nullable();
            $table->enum('action', ['create', 'update', 'soft_delete', 'restore', 'force_deleted']);
            $table->softDeletes(); // Для deleted_at
            $table->timestamps(); // Для created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
