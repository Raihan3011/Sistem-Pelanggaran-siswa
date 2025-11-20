<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSanksi extends Model
{
    use HasFactory;

    protected $table = 'jenis_sanksi';
    protected $primaryKey = 'jenis_sanksi_id';

    protected $fillable = [
        'nama_sanksi',
        'deskripsi',
        'poin_minimal',
        'poin_maksimal'
    ];
}
