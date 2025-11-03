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
        Schema::table('products', function (Blueprint $table) {
            // Ubah tipe data kolom 'price' menjadi BIGINT
            // Kita gunakan ->change() untuk memodifikasi kolom yang sudah ada
            $table->bigInteger('price')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Kembalikan ke integer jika migrasi di-rollback
            // (Penting untuk konsistensi)
            $table->integer('price')->change();
        });
    }
};
