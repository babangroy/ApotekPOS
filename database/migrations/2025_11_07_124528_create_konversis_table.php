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
        Schema::create('konversis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->restrictOnDelete();
            $table->foreignId('satuan_id')->constrained('satuans')->restrictOnDelete();
            $table->unsignedInteger('konversi_ke_satuan_terkecil');
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->unique(['barang_id', 'satuan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konversis');
    }
};
