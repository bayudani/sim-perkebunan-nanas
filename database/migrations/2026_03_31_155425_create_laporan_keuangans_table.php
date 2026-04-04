<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_keuangans', function (Blueprint $table) {
        $table->id();
        $table->string('periode', 20); // Contoh: "Desember 2025"
        $table->decimal('total_pemasukan', 12, 2);
        $table->decimal('total_pengeluaran', 12, 2);
        $table->decimal('saldo', 12, 2);
        $table->date('tanggal_cetak');
        
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangans');
    }
};
