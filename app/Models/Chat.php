<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'chat_id';
    protected $fillable = ['pengirim_id', 'penerima_id', 'pesan', 'dibaca'];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id', 'user_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id', 'user_id');
    }
}
