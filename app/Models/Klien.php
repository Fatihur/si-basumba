<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'klien';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_wa',
        'alamat',
        'kategori',
        'status_bimbingan',
        'petugas_id',
        'tanggal_mulai_bimbingan',
        'tanggal_selesai_bimbingan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai_bimbingan' => 'date',
            'tanggal_selesai_bimbingan' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class);
    }
}
