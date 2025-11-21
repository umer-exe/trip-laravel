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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('overview');
            $table->string('location');
            $table->string('duration');
            $table->decimal('price', 10, 2);
            $table->string('type');
            $table->json('highlights')->nullable();
            $table->json('itinerary')->nullable();
            $table->json('available_dates')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_featured')->default(false);
            $table->string('thumbnail_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
