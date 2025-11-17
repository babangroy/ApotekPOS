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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->index();
            $table->string('no_faktur')->nullable()->index();
            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->date('tgl_pembelian')->index();
            $table->date('tgl_jth_tempo')->nullable();
            $table->enum('status_pembayaran', ['Lunas', 'Dp', 'Belum Bayar', 'Sebagian'])->default('Belum Bayar')->index();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('ppn', 15, 2)->default(0);
            $table->decimal('total_akhir', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->foreignId('oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
