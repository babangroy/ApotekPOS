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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('no_batch')->nullable()->index();
            $table->foreignId('barang_id')->constrained('barangs')->restrictOnDelete();
            $table->enum('sumber', ['Pembelian', 'Stok Awal']);
            $table->foreignId('pembelian_id')->nullable()->constrained('pembelians')->restrictOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->restrictOnDelete();
            $table->date('tgl_kadaluarsa')->index();
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->decimal('jlh_tersedia', 15, 2)->default(0);
            $table->decimal('harga_beli_satuan', 15, 2)->default(0);
            $table->enum('status', ['Tersedia', 'Habis', 'Kadaluarsa', 'Rusak'])->default('Tersedia')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
