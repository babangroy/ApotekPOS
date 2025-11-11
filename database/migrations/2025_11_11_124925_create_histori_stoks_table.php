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
        Schema::create('histori_stoks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->restrictOnDelete();

            $table->foreignId('batch_id')
                ->constrained('batches')
                ->restrictOnDelete();

            $table->enum('referensi', ['Pembelian', 'Penjualan', 'SO', 'Penarikan'])
                ->index();

            $table->unsignedBigInteger('id_referensi')->nullable();

            $table->decimal('jlh_sebelum', 15, 2)->default(0);
            $table->decimal('jlh_perubahan', 15, 2)->default(0);
            $table->decimal('jlh_setelah', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_stoks');
    }
};
