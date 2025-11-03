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
            // Tambahkan kolom category_id
            $table->foreignId('category_id')
                  ->nullable() // Boleh null jika produk tidak punya kategori
                  ->after('price') // Posisikan setelah kolom harga
                  ->constrained('categories') // Buat foreign key ke tabel categories
                  ->onDelete('set null'); // Jika kategori dihapus, set category_id di produk jadi null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus constraint dan kolom jika di-rollback
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
