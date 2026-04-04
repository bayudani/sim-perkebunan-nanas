<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanKeuangan extends Model
{
     use HasFactory;

    protected $fillable = [
        'periode', 'total_pemasukan', 'total_pengeluaran', 'saldo', 'tanggal_cetak', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
