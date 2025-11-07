<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konversi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'barang_id',
        'satuan_id',
        'konversi_ke_satuan_terkecil',
        'urutan',
        'is_default',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
