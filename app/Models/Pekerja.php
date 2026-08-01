<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pekerja extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pekerja', 'nama', 'jenis_kelamin', 'no_hp', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perawatans()
    {
        return $this->belongsToMany(Perawatan::class, 'perawatan_pekerja');
    }

    public function riwayatBudidayas()
    {
        return $this->belongsToMany(RiwayatBudidaya::class, 'riwayat_budidaya_pekerja');
    }
}
