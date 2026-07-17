<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan_code', 10);
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->timestamps();

            // Relasi Foreign Key
            $table->foreign('kecamatan_code')
                  ->references('code')
                  ->on('kecamatan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelurahan');
    }
};