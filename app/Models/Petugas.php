<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jabatan',
        'no_telepon',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function klien(): HasMany
    {
        return $this->hasMany(Klien::class);
    }

    public function wajibLapor(): HasMany
    {
        return $this->hasMany(WajibLapor::class);
    }

    public function litmas(): HasMany
    {
        return $this->hasMany(Litmas::class);
    }

    public function abh(): HasMany
    {
        return $this->hasMany(Abh::class);
    }
}
