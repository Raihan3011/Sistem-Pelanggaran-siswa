<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelanggaran';
    protected $primaryKey = 'jenis_pelanggaran_id';

    protected $fillable = [
        'nama_pelanggaran',
        'point',
        'poin_minimal',
        'poin_maksimal',
        'kategori',
        'deskripsi',
        'sanksi_rekomendasi'
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'jenis_pelanggaran_id', 'jenis_pelanggaran_id');
    }

    // Accessor untuk nama dan poin (untuk kompatibilitas)
    public function getNamaAttribute()
    {
        return $this->nama_pelanggaran;
    }

    public function getPoinAttribute()
    {
        return $this->point;
    }
}