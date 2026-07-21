<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendapatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'hasil_panen_id', 'jumlah_terjual', 'harga_per_kg', 'total_pendapatan', 'keterangan', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasilPanen()
    {
        return $this->belongsTo(HasilPanen::class);
    }
}
