<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilPanen extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_panen', 'jumlah_panen', 'jumlah_terjual', 'kualitas', 'keterangan', 'user_id'
    ];

    public function getSisaAttribute()
    {
        return $this->jumlah_panen - $this->jumlah_terjual;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendapatans()
    {
        return $this->hasMany(Pendapatan::class);
    }
}
