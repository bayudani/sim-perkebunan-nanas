<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatBudidaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'jenis_kegiatan', 'blok_lahan', 'keterangan', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pekerjas()
    {
        return $this->belongsToMany(Pekerja::class, 'riwayat_budidaya_pekerja');
    }
}
