<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;

    protected $primaryKey = 'wali_kelas_id';
    protected $table = 'wali_kelas';

    protected $fillable = [
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'bidang_studi',
        'email',
        'no_telp',
        'status',
        'tahun_ajaran_id',
        'user_id',
    ];

    // ==================== RELATIONSHIPS ====================

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'tahun_ajaran_id');
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id', 'user_id');
    }

    public function kelasAmpu()
    {
        return $this->belongsTo(Kelas::class, 'user_id', 'wali_kelas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // ==================== ACCESSORS ====================

    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getStatusTextAttribute()
    {
        return $this->status == 'Aktif' ? 'Aktif' : 'Non-Aktif';
    }

    public function getIsAktifAttribute()
    {
        return $this->status === 'Aktif';
    }

    public function getJumlahKelasAttribute()
    {
        return $this->kelas()->count();
    }

    public function getKelasAktifAttribute()
    {
        return $this->kelas()->withCount('siswa')->get();
    }

    // ==================== SCOPES ====================

    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function scopeBidangStudi($query, $bidangStudi)
    {
        return $query->where('bidang_studi', $bidangStudi);
    }

    public function scopeJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('jenis_kelamin', $jenisKelamin);
    }

    // ==================== METHODS ====================

    public function activate()
    {
        $this->update(['status' => 'Aktif']);
    }

    public function deactivate()
    {
        $this->update(['status' => 'Non-Aktif']);
    }

    public function canBeDeleted()
    {
        return $this->kelas === null;
    }

    public function getInfoWaliKelas()
    {
        return [
            'wali_kelas_id' => $this->wali_kelas_id,
            'nip' => $this->nip,
            'nama_guru' => $this->nama_guru,
            'bidang_studi' => $this->bidang_studi,
            'email' => $this->email,
            'no_telp' => $this->no_telp,
            'status' => $this->status_text,
            'jumlah_kelas' => $this->jumlah_kelas,
            'kelas_aktif' => $this->kelas_aktif->pluck('nama_kelas')->toArray(),
        ];
    }

    public function getStatistik()
    {
        $kelas = $this->kelas()->withCount('siswa')->get();

        return [
            'total_kelas' => $kelas->count(),
            'total_siswa' => $kelas->sum('siswa_count'),
            'kelas_list' => $kelas->map(function($kelas) {
                return [
                    'nama_kelas' => $kelas->nama_kelas,
                    'jurusan' => $kelas->jurusan,
                    'jumlah_siswa' => $kelas->siswa_count,
                ];
            })->toArray(),
        ];
    }
}