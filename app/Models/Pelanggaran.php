<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';
    protected $primaryKey = 'pelanggaran_id';

    protected $fillable = [
        'siswa_id',
        'guru_pencatat',
        'jenis_pelanggaran_id',
        'tahun_ajaran_id',
        'point',
        'keterangan',
        'bukti_foto',
        'status_verifikasi',
        'guru_verifikator',
        'catatan_verifikasi',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'jenis_pelanggaran_id', 'jenis_pelanggaran_id');
    }

    public function guruPencatat()
    {
        return $this->belongsTo(User::class, 'guru_pencatat', 'user_id');
    }

    public function guruVerifikator()
    {
        return $this->belongsTo(User::class, 'guru_verifikator', 'user_id');
    }

    public function sanksi()
    {
        return $this->hasOne(Sanksi::class, 'pelanggaran_id', 'pelanggaran_id');
    }

    public function getTanggalPelanggaranAttribute()
    {
        return $this->tanggal;
    }
}