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
        Schema::create('sertifikat_veteriner', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('mitra_id')->constrained('mitras')->cascadeOnDelete();
            $table->string('jenis_hewan');
            $table->decimal('jeroan_merah', 8, 2)->default(0);
            $table->decimal('jeroan_hijau', 8, 2)->default(0);
            $table->decimal('karkas', 8, 2)->default(0);
            $table->decimal('kulit', 8, 2)->default(0);
            $table->string('asal_produk');
            $table->string('nama_penerima');
            $table->text('alamat_penerima');
            $table->text('keterangan')->nullable();
            $table->string('dokter_hewan');
            $table->string('scan_sertifikat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat_veteriner');
    }
};
