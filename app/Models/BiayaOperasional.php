<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BiayaOperasional extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'jenis_biaya', 'blok_lahan', 'jumlah', 'keterangan', 'user_id', 'perawatan_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perawatan()
    {
        return $this->belongsTo(Perawatan::class);
    }
}
