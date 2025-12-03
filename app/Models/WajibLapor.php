<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WajibLapor extends Model
{
    use HasFactory;

    protected $table = 'wajib_lapor';

    protected $fillable = [
        'tanggal_lapor',
        'email',
        'nama_lengkap',
        'kategori_klien',
        'no_wa',
        'alamat',
        'status_bimbingan',
        'petugas_id',
        'foto_selfie',
        'status_verifikasi',
        'catatan_verifikasi',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lapor' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class);
    }

    public function verifiedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
