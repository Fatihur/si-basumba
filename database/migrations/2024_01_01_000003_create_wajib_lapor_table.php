<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wajib_lapor', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_lapor');
            $table->string('email');
            $table->string('nama_lengkap');
            $table->enum('kategori_klien', ['anak', 'dewasa']);
            $table->string('no_wa');
            $table->text('alamat');
            $table->enum('status_bimbingan', ['pembebasan_bersyarat', 'cuti_bersyarat', 'asimilasi', 'cmd']);
            $table->foreignId('petugas_id')->nullable()->constrained('petugas')->onDelete('set null');
            $table->string('foto_selfie');
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_verifikasi')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wajib_lapor');
    }
};
