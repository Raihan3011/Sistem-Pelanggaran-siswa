<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'tahun_ajaran_id';
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'kode_tahun',
        'tahun_ajaran',
        'semester',
        'status_aktif',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'semester' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class, 'tahun_ajaran_id', 'tahun_ajaran_id');
    }



    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'tahun_ajaran_id', 'tahun_ajaran_id');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'tahun_ajaran_id', 'tahun_ajaran_id');
    }

    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class, 'tahun_ajaran_id', 'tahun_ajaran_id');
    }

    // ==================== ACCESSORS ====================

    public function getStatusTextAttribute()
    {
        return $this->status_aktif ? 'Aktif' : 'Tidak Aktif';
    }

    public function getSemesterTextAttribute()
    {
        return $this->semester == 1 ? 'Ganjil' : 'Genap';
    }

    public function getDurasiAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
    }

    public function getIsBerjalanAttribute()
    {
        $today = now()->format('Y-m-d');
        return $this->tanggal_mulai <= $today && $this->tanggal_selesai >= $today;
    }

    // ==================== SCOPES ====================

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    public function scopeBerjalan($query)
    {
        $today = now()->format('Y-m-d');
        return $query->where('tanggal_mulai', '<=', $today)
                    ->where('tanggal_selesai', '>=', $today);
    }

    // ==================== METHODS ====================

    public static function getAktif()
    {
        return static::where('status_aktif', true)->first();
    }

    public function activate()
    {
        // Nonaktifkan semua tahun ajaran lainnya
        static::where('tahun_ajaran_id', '!=', $this->tahun_ajaran_id)
              ->update(['status_aktif' => false]);

        // Aktifkan tahun ajaran ini
        $this->update(['status_aktif' => true]);
    }

    public function deactivate()
    {
        $this->update(['status_aktif' => false]);
    }

    public function canDelete()
    {
        // Cek apakah tahun ajaran digunakan di tabel lain
        return $this->waliKelas()->count() === 0 &&
               $this->pelanggaran()->count() === 0 &&
               $this->prestasi()->count() === 0 &&
               $this->bimbinganKonseling()->count() === 0;
    }
}