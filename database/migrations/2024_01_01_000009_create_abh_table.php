<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_kepolisian_id')->nullable()->constrained('instansi_kepolisian')->onDelete('set null');
            $table->string('nomor_surat_permintaan');
            $table->date('tanggal_surat_permintaan');
            $table->string('file_surat_permintaan');
            $table->text('perkara_kasus');
            $table->string('nama_penyidik');
            $table->string('telepon_penyidik');
            $table->string('file_bap')->nullable();

            // Status & Penugasan
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->foreignId('petugas_id')->nullable()->constrained('petugas')->onDelete('set null');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abh');
    }
};
