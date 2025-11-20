<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanSanksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'pelaksanaan_id';
    protected $table = 'pelaksanaan_sanksi';

    protected $fillable = [
        'sanksi_id',
        'tanggal_pelaksanaan',
        'deskripsi_pelaksanaan',
        'bukti_pelaksanaan',
        'status',
        'catatan',
        'guru_pengawas',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Relationship dengan model Sanksi
     */
    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class, 'sanksi_id', 'sanksi_id');
    }

    /**
     * Relationship dengan model User (Guru Pengawas)
     */
    public function guruPengawas()
    {
        return $this->belongsTo(User::class, 'guru_pengawas', 'id_user');
    }

    // ==================== ACCESSORS & MUTATORS ====================

    /**
     * Accessor untuk status text
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            'Terlaksana' => 'Terlaksana',
            'Tidak Terlaksana' => 'Tidak Terlaksana',
            'Ditunda' => 'Ditunda',
            'Dalam Proses' => 'Dalam Proses'
        ];
        
        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Accessor untuk cek apakah ada bukti
     */
    public function getHasBuktiAttribute()
    {
        return !empty($this->bukti_pelaksanaan);
    }

    /**
     * Accessor untuk status Terlaksana
     */
    public function getIsTerlaksanaAttribute()
    {
        return $this->status === 'Terlaksana';
    }

    /**
     * Accessor untuk status Dalam Proses
     */
    public function getIsDalamProsesAttribute()
    {
        return $this->status === 'Dalam Proses';
    }

    /**
     * Accessor untuk status Ditunda
     */
    public function getIsDitundaAttribute()
    {
        return $this->status === 'Ditunda';
    }

    /**
     * Accessor untuk status Tidak Terlaksana
     */
    public function getIsTidakTerlaksanaAttribute()
    {
        return $this->status === 'Tidak Terlaksana';
    }

    /**
     * Accessor untuk format tanggal Indonesia
     */
    public function getTanggalPelaksanaanIndoAttribute()
    {
        return $this->tanggal_pelaksanaan?->translatedFormat('d F Y');
    }

    /**
     * Accessor untuk URL bukti pelaksanaan
     */
    public function getBuktiUrlAttribute()
    {
        return $this->bukti_pelaksanaan ? asset('storage/bukti-pelaksanaan/' . $this->bukti_pelaksanaan) : null;
    }

    // ==================== SCOPES ====================

    /**
     * Scope untuk filter status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk status Terlaksana
     */
    public function scopeTerlaksana($query)
    {
        return $query->where('status', 'Terlaksana');
    }

    /**
     * Scope untuk status Dalam Proses
     */
    public function scopeDalamProses($query)
    {
        return $query->where('status', 'Dalam Proses');
    }

    /**
     * Scope untuk status Ditunda
     */
    public function scopeDitunda($query)
    {
        return $query->where('status', 'Ditunda');
    }

    /**
     * Scope untuk status Tidak Terlaksana
     */
    public function scopeTidakTerlaksana($query)
    {
        return $query->where('status', 'Tidak Terlaksana');
    }

    /**
     * Scope untuk filter periode tanggal
     */
    public function scopePeriode($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_pelaksanaan', [$startDate, $endDate]);
    }

    /**
     * Scope untuk filter guru pengawas
     */
    public function scopeGuruPengawas($query, $guruId)
    {
        return $query->where('guru_pengawas', $guruId);
    }

    /**
     * Scope untuk data dengan bukti
     */
    public function scopeWithBukti($query)
    {
        return $query->whereNotNull('bukti_pelaksanaan');
    }

    /**
     * Scope untuk data tanpa bukti
     */
    public function scopeWithoutBukti($query)
    {
        return $query->whereNull('bukti_pelaksanaan');
    }

    // ==================== METHODS ====================

    /**
     * Cek apakah pelaksanaan sanksi bisa diubah
     */
    public function bisaDiubah()
    {
        return in_array($this->status, ['Dalam Proses', 'Ditunda']);
    }

    /**
     * Cek apakah pelaksanaan sanksi bisa dihapus
     */
    public function bisaDihapus()
    {
        return in_array($this->status, ['Dalam Proses', 'Ditunda']);
    }

    /**
     * Mark sebagai Terlaksana
     */
    public function markAsTerlaksana($bukti = null, $catatan = null)
    {
        $this->update([
            'status' => 'Terlaksana',
            'tanggal_pelaksanaan' => $this->tanggal_pelaksanaan ?? now(),
            'bukti_pelaksanaan' => $bukti ?? $this->bukti_pelaksanaan,
            'catatan' => $catatan ?? $this->catatan
        ]);
    }

    /**
     * Mark sebagai Tidak Terlaksana
     */
    public function markAsTidakTerlaksana($catatan = null)
    {
        $this->update([
            'status' => 'Tidak Terlaksana',
            'catatan' => $catatan ?? $this->catatan
        ]);
    }

    /**
     * Mark sebagai Ditunda
     */
    public function markAsDitunda($catatan = null)
    {
        $this->update([
            'status' => 'Ditunda',
            'catatan' => $catatan ?? $this->catatan
        ]);
    }

    /**
     * Mark sebagai Dalam Proses
     */
    public function markAsDalamProses($catatan = null)
    {
        $this->update([
            'status' => 'Dalam Proses',
            'catatan' => $catatan ?? $this->catatan
        ]);
    }

    /**
     * Get rantai lengkap pelanggaran
     */
    public function getRantaiPelanggaranAttribute()
    {
        return [
            'pelaksanaan' => $this,
            'sanksi' => $this->sanksi,
            'pelanggaran' => $this->sanksi->pelanggaran ?? null,
            'siswa' => $this->sanksi->pelanggaran->siswa ?? null
        ];
    }

    /**
     * Get nama siswa melalui rantai relasi
     */
    public function getNamaSiswaAttribute()
    {
        return $this->sanksi->pelanggaran->siswa->nama ?? 'Tidak Diketahui';
    }

    /**
     * Get jenis pelanggaran melalui rantai relasi
     */
    public function getJenisPelanggaranAttribute()
    {
        return $this->sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? 'Tidak Diketahui';
    }

    /**
     * Get nama guru pengawas
     */
    public function getNamaGuruPengawasAttribute()
    {
        return $this->guruPengawas->name ?? 'Tidak Diketahui';
    }
}