<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MonitoringPelanggaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'monitor_id';
    protected $table = 'monitoring_pelanggaran'; 

    protected $fillable = [
        'pelanggaran_id',
        'guru_kepsek',
        'status_monitoring',
        'catatan_monitoring',
        'tanggal_monitoring',
        'tindak_lanjut',
    ];

    protected $casts = [
        'tanggal_monitoring' => 'date',
    ];

    // ==================== RELATIONSHIPS ====================

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id', 'pelanggaran_id');
    }

    public function guruKepsek()
    {
        return $this->belongsTo(User::class, 'guru_kepsek', 'user_id');
    }

    // ==================== ACCESSORS ====================

    public function getStatusMonitoringTextAttribute()
    {
        $statuses = [
            'Diproses' => 'Dalam Proses',
            'Ditindaklanjuti' => 'Sedang Ditindaklanjuti',
            'Selesai' => 'Selesai',
            'Dibatalkan' => 'Dibatalkan'
        ];
        
        return $statuses[$this->status_monitoring] ?? $this->status_monitoring;
    }

    public function getStatusMonitoringWarnaAttribute()
    {
        $warna = [
            'Diproses' => 'warning',
            'Ditindaklanjuti' => 'info',
            'Selesai' => 'success',
            'Dibatalkan' => 'danger'
        ];
        
        return $warna[$this->status_monitoring] ?? 'secondary';
    }

    public function getIsDiprosesAttribute()
    {
        return $this->status_monitoring === 'Diproses';
    }

    public function getIsDitindaklanjutiAttribute()
    {
        return $this->status_monitoring === 'Ditindaklanjuti';
    }

    public function getIsSelesaiAttribute()
    {
        return $this->status_monitoring === 'Selesai';
    }

    public function getIsDibatalkanAttribute()
    {
        return $this->status_monitoring === 'Dibatalkan';
    }

    public function getCatatanSingkatAttribute()
    {
        if (!$this->catatan_monitoring) {
            return 'Tidak ada catatan';
        }
        
        return strlen($this->catatan_monitoring) > 100 
            ? substr($this->catatan_monitoring, 0, 100) . '...' 
            : $this->catatan_monitoring;
    }

    public function getTindakLanjutSingkatAttribute()
    {
        if (!$this->tindak_lanjut) {
            return 'Belum ada tindak lanjut';
        }
        
        return strlen($this->tindak_lanjut) > 100 
            ? substr($this->tindak_lanjut, 0, 100) . '...' 
            : $this->tindak_lanjut;
    }

    public function getDurasiHariAttribute()
    {
        return $this->created_at->diffInDays(now());
    }

    // ==================== SCOPES ====================

    public function scopeStatus($query, $status)
    {
        return $query->where('status_monitoring', $status);
    }

    public function scopeBaru($query)
    {
        return $query->where('status_monitoring', 'Diproses');
    }

    public function scopeDitindaklanjuti($query)
    {
        return $query->where('status_monitoring', 'Ditindaklanjuti');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status_monitoring', 'Selesai');
    }

    public function scopePeriode($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_monitoring', [$startDate, $endDate]);
    }

    public function scopeGuruKepsek($query, $guruId)
    {
        return $query->where('guru_kepsek', $guruId);
    }

    public function scopePerluPerhatian($query)
    {
        return $query->whereIn('status_monitoring', ['Diproses', 'Ditindaklanjuti'])
                    ->where('created_at', '<=', now()->subDays(7));
    }

    // ==================== METHODS ====================

    public function bisaDiupdate()
    {
        return in_array($this->status_monitoring, ['Diproses', 'Ditindaklanjuti']);
    }

    public function mulaiTindakLanjut($catatan = null)
    {
        if ($this->status_monitoring === 'Diproses') {
            $this->update([
                'status_monitoring' => 'Ditindaklanjuti',
                'catatan_monitoring' => $catatan ?? $this->catatan_monitoring,
            ]);
            return true;
        }
        return false;
    }

    public function selesaikanMonitoring($tindakLanjut, $catatan = null)
    {
        $this->update([
            'status_monitoring' => 'Selesai',
            'tindak_lanjut' => $tindakLanjut,
            'catatan_monitoring' => $catatan ?? $this->catatan_monitoring,
        ]);
    }

    public function batalkanMonitoring($alasan)
    {
        $this->update([
            'status_monitoring' => 'Dibatalkan',
            'catatan_monitoring' => $this->catatan_monitoring . "\n\nDibatalkan: " . $alasan,
        ]);
    }

    public function getInfoMonitoring()
    {
        return [
            'monitor_id' => $this->monitor_id,
            'pelanggaran' => $this->pelanggaran->jenisPelanggaran->nama_pelanggaran,
            'siswa' => $this->pelanggaran->siswa->nama_siswa,
            'kelas' => $this->pelanggaran->siswa->kelas->nama_kelas,
            'guru_kepsek' => $this->guruKepsek->nama_lengkap,
            'status' => $this->status_monitoring_text,
            'status_warna' => $this->status_monitoring_warna,
            'tanggal_monitoring' => $this->tanggal_monitoring->format('d/m/Y'),
            'catatan' => $this->catatan_monitoring,
            'tindak_lanjut' => $this->tindak_lanjut,
            'durasi_hari' => $this->durasi_hari,
        ];
    }

    public function getProgressPercentage()
    {
        $progress = [
            'Diproses' => 25,
            'Ditindaklanjuti' => 50,
            'Selesai' => 100,
            'Dibatalkan' => 0
        ];
        
        return $progress[$this->status_monitoring] ?? 0;
    }

    public function getTimeline()
    {
        $timeline = [
            [
                'status' => 'Monitoring Dimulai',
                'oleh' => $this->guruKepsek->nama_lengkap,
                'tanggal' => $this->created_at->format('d/m/Y H:i'),
                'catatan' => 'Proses monitoring dimulai',
            ]
        ];

        if ($this->status_monitoring === 'Ditindaklanjuti') {
            $timeline[] = [
                'status' => 'Ditindaklanjuti',
                'oleh' => $this->guruKepsek->nama_lengkap,
                'tanggal' => $this->updated_at->format('d/m/Y H:i'),
                'catatan' => $this->catatan_monitoring ?? 'Tindak lanjut sedang dilakukan',
            ];
        }

        if ($this->status_monitoring === 'Selesai') {
            $timeline[] = [
                'status' => 'Selesai',
                'oleh' => $this->guruKepsek->nama_lengkap,
                'tanggal' => $this->updated_at->format('d/m/Y H:i'),
                'catatan' => $this->tindak_lanjut ?? 'Monitoring telah diselesaikan',
            ];
        }

        if ($this->status_monitoring === 'Dibatalkan') {
            $timeline[] = [
                'status' => 'Dibatalkan',
                'oleh' => $this->guruKepsek->nama_lengkap,
                'tanggal' => $this->updated_at->format('d/m/Y H:i'),
                'catatan' => $this->catatan_monitoring ?? 'Monitoring dibatalkan',
            ];
        }

        return $timeline;
    }
}