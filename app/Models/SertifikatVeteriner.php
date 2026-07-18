<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SertifikatVeteriner extends Model
{
    protected $table = 'sertifikat_veteriner';

    protected $fillable = [
        'tanggal',
        'mitra_id',
        'jenis_hewan',
        'jeroan_merah',
        'jeroan_hijau',
        'karkas',
        'kulit',
        'asal_produk',
        'nama_penerima',
        'alamat_penerima',
        'keterangan',
        'dokter_hewan',
        'scan_sertifikat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jeroan_merah' => 'decimal:2',
            'jeroan_hijau' => 'decimal:2',
            'karkas' => 'decimal:2',
            'kulit' => 'decimal:2',
        ];
    }

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class);
    }
}
