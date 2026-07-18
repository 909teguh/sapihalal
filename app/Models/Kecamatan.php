<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
    ];

    // Relasi ke Kelurahan
    public function kelurahans(): HasMany
    {
        return $this->hasMany(Kelurahan::class, 'kecamatan_code', 'code');
    }
}
