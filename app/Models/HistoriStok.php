<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriStok extends Model
{
    use HasFactory;

    protected $table = 'histori_stoks';

    protected $fillable = [
        'barang_id',
        'batch_id',
        'referensi',
        'id_referensi',
        'jlh_sebelum',
        'jlh_perubahan',
        'jlh_setelah',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
