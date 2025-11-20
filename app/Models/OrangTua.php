<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrangTua extends Model
{
    use HasFactory;

    protected $primaryKey = 'orang_tua_id';
    protected $table = 'orang_tua';

    protected $fillable = [
        'user_id',
        'siswa_id',
        'hubungan',
        'nama_orang_tua',
        'pekerjaan',
        'pendidikan',
        'no_telp',
        'alamat',
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }

    // ==================== ACCESSORS ====================

    public function getHubunganTextAttribute()
    {
        $hubungan = [
            'Ayah' => 'Ayah',
            'Ibu' => 'Ibu',
            'Wali' => 'Wali'
        ];
        
        return $hubungan[$this->hubungan] ?? $this->hubungan;
    }

    public function getPendidikanTextAttribute()
    {
        $pendidikan = [
            'SD' => 'SD / Sederajat',
            'SMP' => 'SMP / Sederajat',
            'SMA' => 'SMA/SMK Sederajat',
            'D1' => 'Diploma 1',
            'D2' => 'Diploma 2',
            'D3' => 'Diploma 3',
            'D4' => 'Diploma 4',
            'S1' => 'Sarjana (S1)',
            'S2' => 'Magister (S2)',
            'S3' => 'Doktor (S3)'
        ];
        
        return $pendidikan[$this->pendidikan] ?? $this->pendidikan;
    }

    public function getInfoKontakAttribute()
    {
        return [
            'nama' => $this->nama_orang_tua,
            'hubungan' => $this->hubungan_text,
            'no_telp' => $this->no_telp,
            'email' => $this->user->email ?? 'Tidak ada email',
        ];
    }

    public function getAlamatSingkatAttribute()
    {
        return strlen($this->alamat) > 50 
            ? substr($this->alamat, 0, 50) . '...' 
            : $this->alamat;
    }

    public function getIsAyahAttribute()
    {
        return $this->hubungan === 'Ayah';
    }

    public function getIsIbuAttribute()
    {
        return $this->hubungan === 'Ibu';
    }

    public function getIsWaliAttribute()
    {
        return $this->hubungan === 'Wali';
    }

    // ==================== SCOPES ====================

    public function scopeHubungan($query, $hubungan)
    {
        return $query->where('hubungan', $hubungan);
    }

    public function scopeAyah($query)
    {
        return $query->where('hubungan', 'Ayah');
    }

    public function scopeIbu($query)
    {
        return $query->where('hubungan', 'Ibu');
    }

    public function scopeWali($query)
    {
        return $query->where('hubungan', 'Wali');
    }

    public function scopePekerjaan($query, $pekerjaan)
    {
        return $query->where('pekerjaan', 'like', '%' . $pekerjaan . '%');
    }

    public function scopePendidikan($query, $pendidikan)
    {
        return $query->where('pendidikan', $pendidikan);
    }

    // ==================== METHODS ====================

    public function createUserAccount($password = null)
    {
        if ($this->user_id) {
            return $this->user; // Sudah punya user account
        }

        $username = 'ortu_' . $this->siswa->nis . '_' . strtolower($this->hubungan);
        $password = $password ?? $this->siswa->nis; // Default password = NIS siswa

        $user = User::create([
            'username' => $username,
            'password' => bcrypt($password),
            'nama_lengkap' => $this->nama_orang_tua,
            'level' => 'orang_tua',
            'is_active' => true,
        ]);

        $this->update(['user_id' => $user->user_id]);

        return $user;
    }

    public function getInfoOrangTua()
    {
        return [
            'orang_tua_id' => $this->orang_tua_id,
            'nama' => $this->nama_orang_tua,
            'hubungan' => $this->hubungan_text,
            'pekerjaan' => $this->pekerjaan,
            'pendidikan' => $this->pendidikan_text,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'siswa' => $this->siswa->nama_siswa,
            'kelas' => $this->siswa->kelas->nama_kelas,
            'nis' => $this->siswa->nis,
        ];
    }

    public function getAnakAttribute()
    {
        return $this->siswa;
    }

    public function canAccessPortal()
    {
        return $this->user_id !== null && $this->user->is_active;
    }

    public function getNotifikasiTerbaru()
    {
        // Method untuk mendapatkan notifikasi terkait siswa
        $pelanggaran = $this->siswa->pelanggaran()
            ->with('jenisPelanggaran')
            ->where('status_verifikasi', 'Terverifikasi')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        $prestasi = $this->siswa->prestasi()
            ->with('jenisPrestasi')
            ->where('status_verifikasi', 'Terverifikasi')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return [
            'pelanggaran' => $pelanggaran,
            'prestasi' => $prestasi,
        ];
    }
}