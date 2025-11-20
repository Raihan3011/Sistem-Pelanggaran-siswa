<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';
    protected $primaryKey = 'prestasi_id';

    protected $fillable = [
        'siswa_id',
        'jenis_prestasi_id',
        'tahun_ajaran_id',
        'point',
        'tingkat',
        'penghargaan',
        'tanggal',
        'keterangan',
        'bukti_dokumen',
        'guru_pencatat',
        'status_verifikasi',
        'guru_verifikator'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }

    public function guruPencatat()
    {
        return $this->belongsTo(User::class, 'guru_pencatat', 'user_id');
    }

    public function jenisPrestasi()
    {
        return $this->belongsTo(JenisPrestasi::class, 'jenis_prestasi_id', 'jenis_prestasi_id');
    }
}
