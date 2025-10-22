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
        Schema::create('room_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // contoh: Deluxe, Superior, Suite
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // tambahkan kolom category_id ke tabel rooms
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('room_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
        Schema::dropIfExists('room_categories');
    }
};
