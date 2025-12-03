<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Abh extends Model
{
    use HasFactory;

    protected $table = 'abh';

    protected $fillable = [
        'instansi_kepolisian_id',
        'nomor_surat_permintaan',
        'tanggal_surat_permintaan',
        'file_surat_permintaan',
        'perkara_kasus',
        'nama_penyidik',
        'telepon_penyidik',
        'file_bap',
        'status',
        'petugas_id',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat_permintaan' => 'date',
        ];
    }

    public function instansiKepolisian(): BelongsTo
    {
        return $this->belongsTo(InstansiKepolisian::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class);
    }
}
