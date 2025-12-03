<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Litmas extends Model
{
    use HasFactory;

    protected $table = 'litmas';

    protected $fillable = [
        'asal_permintaan_id',
        'jenis_litmas_id',
        'nama_narapidana',
        'nomor_registrasi',
        'tindak_pidana_pasal',
        'nomor_putusan',
        'tanggal_putusan',
        'tanggal_mulai_ditahan',
        'lama_pidana',
        'sepertiga_masa_hukuman',
        'duapertiga_masa_hukuman',
        'tanggal_ekspirasi',
        'nama_penjamin',
        'hubungan_penjamin',
        'telepon_penjamin',
        'status',
        'petugas_id',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_putusan' => 'date',
            'tanggal_mulai_ditahan' => 'date',
            'sepertiga_masa_hukuman' => 'date',
            'duapertiga_masa_hukuman' => 'date',
            'tanggal_ekspirasi' => 'date',
        ];
    }

    public function asalPermintaan(): BelongsTo
    {
        return $this->belongsTo(AsalPermintaan::class);
    }

    public function jenisLitmas(): BelongsTo
    {
        return $this->belongsTo(JenisLitmas::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(LitmasFile::class);
    }
}
