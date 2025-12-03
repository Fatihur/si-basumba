<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstansiKepolisian extends Model
{
    use HasFactory;

    protected $table = 'instansi_kepolisian';

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

    public function abh(): HasMany
    {
        return $this->hasMany(Abh::class);
    }
}
