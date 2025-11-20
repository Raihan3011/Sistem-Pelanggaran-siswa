<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    use HasFactory;

    protected $table = 'sanksi';
    protected $primaryKey = 'sanksi_id';

    protected $fillable = [
        'pelanggaran_id',
        'jenis_sanksi',
        'deskripsi_sanksi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_pelaksanaan',
        'guru_penanggung_jawab'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date'
    ];

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id', 'pelanggaran_id');
    }

    public function guruPenanggungJawab()
    {
        return $this->belongsTo(User::class, 'guru_penanggung_jawab', 'user_id');
    }

    // Accessor untuk mengakses jenis pelanggaran melalui pelanggaran
    public function getJenisPelanggaranAttribute()
    {
        return $this->pelanggaran?->jenisPelanggaran;
    }

    public function getSiswaAttribute()
    {
        return $this->pelanggaran?->siswa;
    }
}