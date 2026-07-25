<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayas', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('code')->unique();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->decimal('delivery_price', 10, 2)->default(0);
            $table->boolean('is_delivery_available')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilaya_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('geoalgeria_id')->unique();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('daira_name')->nullable();
            $table->string('postal_code')->nullable();
            $table->timestamps();

            $table->index(['wilaya_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communes');
        Schema::dropIfExists('wilayas');
    }
};
