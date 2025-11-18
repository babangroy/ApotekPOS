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
        Schema::create('hargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->restrictOnDelete();
            $table->foreignId('batch_id')->constrained('batches')->restrictOnDelete();
            $table->decimal('harga_umum', 15, 2)->default(0);
            $table->decimal('harga_bidan', 15, 2)->default(0);
            $table->boolean('is_override', 15, 2)->default(false);
            $table->boolean('is_active', 15, 2)->default(true);
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hargas');
    }
};
