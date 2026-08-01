<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_budidaya_pekerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('riwayat_budidaya_id')->constrained('riwayat_budidayas')->onDelete('cascade');
            $table->foreignId('pekerja_id')->constrained('pekerjas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_budidaya_pekerja');
    }
};
