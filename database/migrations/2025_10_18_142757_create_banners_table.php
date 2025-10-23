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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            // Kolom hotel_id boleh null
            $table->unsignedBigInteger('hotel_id')->nullable();

            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->date('active_from')->nullable();
            $table->date('active_to')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign key tetap ada, tapi tidak wajib
            $table->foreign('hotel_id')
                ->references('id')
                ->on('hotels')
                ->onDelete('set null'); // kalau hotel dihapus, hotel_id jadi null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
