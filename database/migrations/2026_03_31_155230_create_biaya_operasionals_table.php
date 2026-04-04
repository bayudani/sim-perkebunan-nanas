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
        Schema::create('biaya_operasionals', function (Blueprint $table) {
            $table->id();
        $table->date('tanggal');
        $table->string('jenis_biaya', 50);
        $table->decimal('jumlah', 12, 2);
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
        Schema::dropIfExists('biaya_operasionals');
    }
};
