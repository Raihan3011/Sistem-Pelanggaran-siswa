<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganKonseling extends Model
{
    use HasFactory;

    protected $primaryKey = 'bk_id';
    protected $table = 'bimbingan_konseling';

    protected $fillable = [
        'siswa_id',
        'guru_konselor',
        'tahun_ajaran_id',
        'jenis_layanan',
        'topik',
        'keluhan_masalah',
        'tindakan_solusi',
        'status',
        'tanggal_konseling',
        'tanggal_tindak_lanjut',
    ];

    protected $casts = [
        'tanggal_konseling' => 'date',
        'tanggal_tindak_lanjut' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('tanggal_konseling', 'desc');
        });
    }

    // ==================== RELATIONSHIPS ====================

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }

    public function guruKonselor()
    {
        return $this->belongsTo(User::class, 'guru_konselor', 'user_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id_tahun_ajaran');
    }

    // ==================== ACCESSORS ====================

    public function getStatusTextAttribute()
    {
        $statuses = [
            'Pending' => 'Menunggu',
            'Proses' => 'Dalam Proses',
            'Selesai' => 'Selesai',
            'Tindak Lanjut' => 'Perlu Tindak Lanjut'
        ];
        
        return $statuses[$this->status] ?? $this->status;
    }

    public function getJenisLayananSingkatAttribute()
    {
        $layanan = [
            'Konseling Individual' => 'Individual',
            'Konseling Kelompok' => 'Kelompok',
            'Bimbingan Klasikal' => 'Klasikal',
            'Lainnya' => 'Lainnya'
        ];
        
        return $layanan[$this->jenis_layanan] ?? $this->jenis_layanan;
    }

    public function getIsPendingAttribute()
    {
        return $this->status === 'Pending';
    }

    public function getIsProsesAttribute()
    {
        return $this->status === 'Proses';
    }

    public function getIsSelesaiAttribute()
    {
        return $this->status === 'Selesai';
    }

    public function getIsTindakLanjutAttribute()
    {
        return $this->status === 'Tindak Lanjut';
    }

    public function getKeluhanSingkatAttribute()
    {
        return strlen($this->keluhan_masalah) > 100 
            ? substr($this->keluhan_masalah, 0, 100) . '...' 
            : $this->keluhan_masalah;
    }

    public function getDurasiHariAttribute()
    {
        if (!$this->tanggal_tindak_lanjut) {
            return null;
        }
        
        return $this->tanggal_konseling->diffInDays($this->tanggal_tindak_lanjut);
    }

    // ==================== SCOPES ====================

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeBaru($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'Selesai');
    }

    public function scopePeriode($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_konseling', [$startDate, $endDate]);
    }

    public function scopeJenisLayanan($query, $jenisLayanan)
    {
        return $query->where('jenis_layanan', $jenisLayanan);
    }

    public function scopeGuruKonselor($query, $guruId)
    {
        return $query->where('guru_konselor', $guruId);
    }

    public function scopeSiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    public function scopePerluTindakLanjut($query)
    {
        return $query->where('status', 'Tindak Lanjut')
                    ->orWhere(function($q) {
                        $q->where('status', 'Proses')
                          ->where('tanggal_tindak_lanjut', '<=', now()->addDays(7));
                    });
    }

    // ==================== METHODS ====================

    public function bisaDiupdate()
    {
        return in_array($this->status, ['Pending', 'Proses']);
    }

    public function mulaiKonseling()
    {
        if ($this->status === 'Pending') {
            $this->update(['status' => 'Proses']);
            return true;
        }
        return false;
    }

    public function selesaikanKonseling($tindakanSolusi)
    {
        $this->update([
            'status' => 'Selesai',
            'tindakan_solusi' => $tindakanSolusi,
            'tanggal_tindak_lanjut' => now(),
        ]);
    }

    public function butuhkanTindakLanjut($catatanTambahan = null)
    {
        $currentTindakan = $this->tindakan_solusi ?? '';
        $tindakanBaru = $currentTindakan . "\n\nPerlu Tindak Lanjut: " . $catatanTambahan;

        $this->update([
            'status' => 'Tindak Lanjut',
            'tindakan_solusi' => $tindakanBaru,
            'tanggal_tindak_lanjut' => now()->addDays(7), // Default follow up dalam 7 hari
        ]);
    }

    public function getInfoKonseling()
    {
        return [
            'bk_id' => $this->bk_id,
            'siswa' => $this->siswa->nama_siswa,
            'kelas' => $this->siswa->kelas->nama_kelas,
            'guru_konselor' => $this->guruKonselor->nama_lengkap,
            'jenis_layanan' => $this->jenis_layanan,
            'topik' => $this->topik,
            'status' => $this->status_text,
            'tanggal_konseling' => $this->tanggal_konseling->format('d/m/Y'),
            'durasi' => $this->durasi_hari ? $this->durasi_hari . ' hari' : 'Belum selesai',
        ];
    }

    public function getRingkasanMasalah()
    {
        return [
            'keluhan' => $this->keluhan_masalah,
            'tindakan' => $this->tindakan_solusi,
            'status' => $this->status,
            'progress' => $this->getProgressPercentage(),
        ];
    }

    public function getProgressPercentage()
    {
        $progress = [
            'Pending' => 25,
            'Proses' => 50,
            'Tindak Lanjut' => 75,
            'Selesai' => 100
        ];
        
        return $progress[$this->status] ?? 0;
    }
}