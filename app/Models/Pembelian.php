<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'no_faktur',
        'supplier_id',
        'tgl_pembelian',
        'tgl_jth_tempo',
        'tgl_jth_tempo',
        'status_pembayaran',
        'subtotal',
        'diskon',
        'ppn',
        'total_akhir',
        'catatan',
        'oleh',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class, 'pembelian_id');
    }
}
