<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets');
            $table->string('title');
            $table->text('description');
            $table->date('incident_date');
            $table->string('status')->default('Open');
            $table->string('severity')->default('Medium');
            $table->foreignId('reported_by')->constrained('users');
            $table->foreignId('resolved_by')->nullable()->constrained('users');
            $table->date('resolved_date')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();

            $table->index(['asset_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
