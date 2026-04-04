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
        Schema::create('pendapatans', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->foreignId('hasil_panen_id')->constrained('hasil_panens')->onDelete('cascade');
        $table->decimal('harga_per_kg', 12, 2);
        $table->decimal('total_pendapatan', 12, 2);
        $table->string('keterangan', 255)->nullable();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendapatans');
    }
};
