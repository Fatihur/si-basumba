<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('litmas', function (Blueprint $table) {
            $table->id();
            // Asal & Jenis
            $table->foreignId('asal_permintaan_id')->nullable()->constrained('asal_permintaan')->onDelete('set null');
            $table->foreignId('jenis_litmas_id')->nullable()->constrained('jenis_litmas')->onDelete('set null');

            // Data Narapidana
            $table->string('nama_narapidana');
            $table->string('nomor_registrasi');
            $table->text('tindak_pidana_pasal');
            $table->string('nomor_putusan')->nullable();
            $table->date('tanggal_putusan')->nullable();
            $table->date('tanggal_mulai_ditahan')->nullable();
            $table->string('lama_pidana')->nullable();
            $table->date('sepertiga_masa_hukuman')->nullable();
            $table->date('duapertiga_masa_hukuman')->nullable();
            $table->date('tanggal_ekspirasi')->nullable();

            // Data Penjamin
            $table->string('nama_penjamin')->nullable();
            $table->string('hubungan_penjamin')->nullable();
            $table->string('telepon_penjamin')->nullable();

            // Status
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->foreignId('petugas_id')->nullable()->constrained('petugas')->onDelete('set null');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('litmas');
    }
};
