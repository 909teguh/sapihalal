<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mitra extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'kecamatan_alamat',
        'kelurahan_alamat',
        'pemilik',
        'koordinat',
        'status_aktif',
        'sertifikat',
        'link_gmap',
        'foto',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_alamat', 'code');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_alamat', 'code');
    }
}
