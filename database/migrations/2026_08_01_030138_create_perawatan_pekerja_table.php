<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perawatan_pekerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perawatan_id')->constrained('perawatans')->onDelete('cascade');
            $table->foreignId('pekerja_id')->constrained('pekerjas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perawatan_pekerja');
    }
};
