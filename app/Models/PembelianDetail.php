<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_id',
        'barang_id',
        'satuan_id',
        'jumlah',
        'jumlah_terkecil',
        'harga',
        'sub_total',
        'diskon',
        'ppn',
        'total_akhir',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function getBarangNamaWithMerekAttribute(): string
    {
        return $this->barang?->nama . ' - ' . $this->barang?->merek?->nama;
    }

    public function batch()
    {
        return $this->hasOne(Batch::class, 'pembelian_detail_id');
    }
}
