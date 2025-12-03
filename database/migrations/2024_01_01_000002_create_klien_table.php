<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klien', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email')->nullable();
            $table->string('no_wa')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('kategori', ['anak', 'dewasa'])->default('dewasa');
            $table->enum('status_bimbingan', ['pembebasan_bersyarat', 'cuti_bersyarat', 'asimilasi', 'cmd'])->nullable();
            $table->foreignId('petugas_id')->nullable()->constrained('petugas')->onDelete('set null');
            $table->date('tanggal_mulai_bimbingan')->nullable();
            $table->date('tanggal_selesai_bimbingan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klien');
    }
};
