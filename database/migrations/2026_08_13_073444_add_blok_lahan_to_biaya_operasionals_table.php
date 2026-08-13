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
        Schema::table('biaya_operasionals', function (Blueprint $table) {
            $table->string('blok_lahan', 100)->nullable()->after('jenis_biaya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biaya_operasionals', function (Blueprint $table) {
            $table->dropColumn('blok_lahan');
        });
    }
};
