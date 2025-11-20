<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPrestasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'jenis_prestasi_id';
    protected $table = 'jenis_prestasi';

    protected $fillable = [
        'nama_prestasi',
        'jenis',
        'kategori',
        'deskripsi',
        'reward',
    ];

    // ==================== RELATIONSHIPS ====================

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'jenis_prestasi_id', 'jenis_prestasi_id');
    }

    // ==================== ACCESSORS ====================

    public function getJenisTextAttribute()
    {
        $jenis = [
            'Akademik' => 'Akademik',
            'Non-Akademik' => 'Non Akademik',
            'Olahraga' => 'Olahraga',
            'Seni' => 'Seni',
            'Lainnya' => 'Lainnya'
        ];
        
        return $jenis[$this->jenis] ?? $this->jenis;
    }

    public function getKategoriTextAttribute()
    {
        $kategori = [
            'Sekolah' => 'Tingkat Sekolah',
            'Kecamatan' => 'Tingkat Kecamatan',
            'Kota' => 'Tingkat Kota',
            'Provinsi' => 'Tingkat Provinsi',
            'Nasional' => 'Tingkat Nasional',
            'Internasional' => 'Tingkat Internasional'
        ];
        
        return $kategori[$this->kategori] ?? $this->kategori;
    }

    public function getKategoriWarnaAttribute()
    {
        $warna = [
            'Sekolah' => 'primary',
            'Kecamatan' => 'info',
            'Kota' => 'success',
            'Provinsi' => 'warning',
            'Nasional' => 'danger',
            'Internasional' => 'dark'
        ];
        
        return $warna[$this->kategori] ?? 'secondary';
    }

    public function getJenisWarnaAttribute()
    {
        $warna = [
            'Akademik' => 'success',
            'Non-Akademik' => 'info',
            'Olahraga' => 'warning',
            'Seni' => 'primary',
            'Lainnya' => 'secondary'
        ];
        
        return $warna[$this->jenis] ?? 'secondary';
    }

    public function getDeskripsiSingkatAttribute()
    {
        if (!$this->deskripsi) {
            return 'Tidak ada deskripsi';
        }
        
        return strlen($this->deskripsi) > 100 
            ? substr($this->deskripsi, 0, 100) . '...' 
            : $this->deskripsi;
    }

    public function getRewardTextAttribute()
    {
        if (!$this->reward) {
            return 'Tidak ada reward';
        }
        
        return $this->reward;
    }

    public function getIsAkademikAttribute()
    {
        return $this->jenis === 'Akademik';
    }

    public function getIsNonAkademikAttribute()
    {
        return $this->jenis === 'Non-Akademik';
    }

    public function getIsOlahragaAttribute()
    {
        return $this->jenis === 'Olahraga';
    }

    public function getIsSeniAttribute()
    {
        return $this->jenis === 'Seni';
    }

    // ==================== SCOPES ====================

    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeAkademik($query)
    {
        return $query->where('jenis', 'Akademik');
    }

    public function scopeNonAkademik($query)
    {
        return $query->where('jenis', 'Non-Akademik');
    }

    public function scopeOlahraga($query)
    {
        return $query->where('jenis', 'Olahraga');
    }

    public function scopeSeni($query)
    {
        return $query->where('jenis', 'Seni');
    }

    public function scopeTingkat($query, $tingkat)
    {
        return $query->where('kategori', $tingkat);
    }

    public function scopePalingSering($query, $limit = 10)
    {
        return $query->withCount('prestasi')
            ->orderBy('prestasi_count', 'desc')
            ->limit($limit);
    }

    // ==================== METHODS ====================

    public function getInfoJenisPrestasi()
    {
        return [
            'jenis_prestasi_id' => $this->jenis_prestasi_id,
            'nama_prestasi' => $this->nama_prestasi,
            'jenis' => $this->jenis_text,
            'kategori' => $this->kategori_text,
            'kategori_warna' => $this->kategori_warna,
            'jenis_warna' => $this->jenis_warna,
            'deskripsi' => $this->deskripsi,
            'reward' => $this->reward,
            'total_prestasi' => $this->prestasi()->count(),
        ];
    }

    public function getStatistikPenggunaan()
    {
        $totalPrestasi = $this->prestasi()->count();
        $prestasiBulanIni = $this->prestasi()
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->count();

        $prestasiTerverifikasi = $this->prestasi()
            ->where('status_verifikasi', 'Terverifikasi')
            ->count();

        return [
            'total_prestasi' => $totalPrestasi,
            'prestasi_bulan_ini' => $prestasiBulanIni,
            'prestasi_terverifikasi' => $prestasiTerverifikasi,
            'persentase_verifikasi' => $totalPrestasi > 0 
                ? round(($prestasiTerverifikasi / $totalPrestasi) * 100, 2)
                : 0,
        ];
    }

    public function canBeDeleted()
    {
        return $this->prestasi()->count() === 0;
    }

    public function getPointReward()
    {
        // Sistem point berdasarkan kategori prestasi
        $point = [
            'Sekolah' => 10,
            'Kecamatan' => 20,
            'Kota' => 30,
            'Provinsi' => 50,
            'Nasional' => 75,
            'Internasional' => 100
        ];
        
        return $point[$this->kategori] ?? 5;
    }

    public static function getByJenis($jenis)
    {
        return static::where('jenis', $jenis)->get();
    }

    public static function getByKategori($kategori)
    {
        return static::where('kategori', $kategori)->get();
    }

    public function getRekomendasiPoint()
    {
        return "Prestasi {$this->kategori_text} direkomendasikan {$this->getPointReward()} point";
    }
}