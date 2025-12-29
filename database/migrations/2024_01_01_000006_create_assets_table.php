<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->unique()->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_end_date')->nullable();
            $table->decimal('asset_value', 15, 2)->default(0);
            $table->string('status')->default('Available');
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('asset_id');
            $table->index('serial_number');
            $table->index('status');
            $table->index('category_id');
            $table->index('location_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
