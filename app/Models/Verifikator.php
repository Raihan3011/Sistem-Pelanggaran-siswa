<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikator extends Model
{
    use HasFactory;

    protected $table = 'verifikator';
    protected $primaryKey = 'verifikator_id';

    protected $fillable = [
        'user_id',
        'nama_verifikator',
        'nip',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
