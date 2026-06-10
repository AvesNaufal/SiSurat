<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    public $timestamps = false;

    protected $table = 'surat';

    protected $fillable = [
        'nim',
        'nama',
        'prodi',
        'semester',
        'jenis_surat',
        'tujuan',
        'alamat',
        'rentang_waktu',
        'nomor_surat',
        'file_pdf',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}
