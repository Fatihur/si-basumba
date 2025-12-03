<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsalPermintaan extends Model
{
    use HasFactory;

    protected $table = 'asal_permintaan';

    protected $fillable = [
        'nama',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function litmas(): HasMany
    {
        return $this->hasMany(Litmas::class);
    }
}
