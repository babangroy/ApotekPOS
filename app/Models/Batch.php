<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_batch',
        'barang_id',
        'sumber',
        'pembelian_id',
        'pembelian_detail_id',
        'supplier_id',
        'tgl_kadaluarsa',
        'jumlah',
        'jlh_tersedia',
        'harga_beli_satuan',
        'status',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function pembelianDetail()
    {
        return $this->belongsTo(PembelianDetail::class);
    }

    // public function konversis()
    // {
    //     return $this->belongsTo(Barang::class, 'barang_id')
    //         ->with('konversis');
    // }


}
