<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'batch_id',
        'harga_umum',
        'harga_bidan',
        'is_override',
        'is_active'
    ];

    public function barangs()
    {
        return $this->belongsTo(Barang::class);
    }

    public function batches()
    {
        return $this->belongsTo(Batch::class);
    }
}
