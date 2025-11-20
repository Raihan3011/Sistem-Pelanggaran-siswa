<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'siswa_id';

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'nama_siswa',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'no_telp',
        'kelas_id',
        'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'siswa_id', 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function orangTua()
    {
        return $this->hasMany(OrangTua::class, 'siswa_id', 'siswa_id');
    }

    // Accessor untuk nama (untuk kompatibilitas)
    public function getNamaAttribute()
    {
        return $this->nama_siswa;
    }

    // Route key name untuk model binding
    public function getRouteKeyName()
    {
        return 'siswa_id';
    }
}