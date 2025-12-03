<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('litmas_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('litmas_id')->constrained('litmas')->onDelete('cascade');
            $table->enum('jenis_file', [
                'print_summary',
                'ispn',
                'berkas_putusan',
                'laporan_perkembangan',
                'salinan_register_f',
                'kk_klien',
                'ktp_klien',
                'ktp_penjamin',
                'kk_penjamin'
            ]);
            $table->string('nama_file');
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('litmas_files');
    }
};
