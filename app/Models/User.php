<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'level',
        'can_verify',
        'is_active',
        'last_login',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'can_verify' => 'boolean',
        'is_active' => 'boolean',
    ];

    // ==================== RELATIONSHIPS ====================
    
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id', 'user_id');
    }

    public function waliKelas()
    {
        return $this->hasOne(WaliKelas::class, 'user_id', 'user_id');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'user_id', 'user_id');
    }

    public function pelanggaranPencatat()
    {
        return $this->hasMany(Pelanggaran::class, 'user_pencatat', 'user_id');
    }

    public function pelanggaranVerifikator()
    {
        return $this->hasMany(Pelanggaran::class, 'user_verifikator', 'user_id');
    }

    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class, 'user_id', 'user_id');
    }

    public function sanksiPenanggungJawab()
    {
        return $this->hasMany(Sanksi::class, 'guru_penanggung_jawab', 'user_id');
    }

    public function pelaksanaanSanksiPengawas()
    {
        return $this->hasMany(PelaksanaanSanksi::class, 'guru_pengawas', 'user_id');
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCanVerify($query)
    {
        return $query->where('can_verify', true);
    }

    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeAdmin($query)
    {
        return $query->where('level', 'admin');
    }

    public function scopeGuru($query)
    {
        return $query->where('level', 'guru');
    }

    public function scopeKesiswaan($query)
    {
        return $query->where('level', 'kesiswaan');
    }

    public function scopeBk($query)
    {
        return $query->where('level', 'bk');
    }

    public function scopeKepalaSekolah($query)
    {
        return $query->where('level', 'kepala_sekolah');
    }

    // ==================== ACCESSORS ====================

    public function getLevelTextAttribute()
    {
        $levels = [
            'admin' => 'Administrator',
            'guru' => 'Guru',
            'kesiswaan' => 'Staff Kesiswaan',
            'bk' => 'Guru BK',
            'wali_kelas' => 'Wali Kelas',
            'kepala_sekolah' => 'Kepala Sekolah',
            'orang_tua' => 'Orang Tua',
            'siswa' => 'Siswa'
        ];
        
        return $levels[$this->level] ?? $this->level;
    }

    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Non-Aktif';
    }

    public function getNameAttribute()
    {
        return $this->nama_lengkap;
    }

    // ==================== METHODS ====================

    public function updateLastLogin()
    {
        $this->update(['last_login' => now()]);
    }

    public function canAccessDashboard()
    {
        return $this->is_active;
    }

    public function canManagePelanggaran()
    {
        return in_array($this->level, ['admin', 'guru', 'kesiswaan', 'bk', 'kepala_sekolah']) && $this->is_active;
    }

    public function canVerifyData()
    {
        return $this->can_verify && $this->is_active;
    }

    public function canManageUsers()
    {
        return in_array($this->level, ['admin', 'kepala_sekolah']) && $this->is_active;
    }

    public function getDashboardStats()
    {
        $stats = [];

        switch ($this->level) {
            case 'admin':
            case 'kesiswaan':
                $stats['total_siswa'] = \App\Models\Siswa::count();
                $stats['total_pelanggaran'] = \App\Models\Pelanggaran::count();
                $stats['pelanggaran_pending'] = \App\Models\Pelanggaran::pending()->count();
                $stats['sanksi_berjalan'] = \App\Models\Sanksi::berjalan()->count();
                break;

            case 'guru':
                $stats['pelanggaran_dicatat'] = $this->pelanggaranPencatat()->count();
                $stats['sanksi_ditanggungjawabi'] = $this->sanksiPenanggungJawab()->count();
                $stats['pelaksanaan_diawasi'] = $this->pelaksanaanSanksiPengawas()->count();
                break;

            case 'bk':
                $stats['bimbingan_aktif'] = $this->bimbinganKonseling()->where('status', 'Proses')->count();
                $stats['total_bimbingan'] = $this->bimbinganKonseling()->count();
                $stats['siswa_bermasalah'] = \App\Models\Pelanggaran::with('siswa')
                    ->terverifikasi()
                    ->get()
                    ->groupBy('siswa_id')
                    ->count();
                break;

            case 'kepala_sekolah':
                $stats['total_siswa'] = \App\Models\Siswa::count();
                $stats['pelanggaran_verifikasi'] = \App\Models\Pelanggaran::pending()->count();
                $stats['monitoring_pelanggaran'] = \App\Models\MonitoringPelanggaran::where('status_monitoring', 'Diproses')->count();
                break;
        }

        return $stats;
    }
}