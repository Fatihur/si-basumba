<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LitmasFile extends Model
{
    use HasFactory;

    protected $table = 'litmas_files';

    protected $fillable = [
        'litmas_id',
        'jenis_file',
        'nama_file',
        'path',
    ];

    public function litmas(): BelongsTo
    {
        return $this->belongsTo(Litmas::class);
    }
}
