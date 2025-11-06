<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonversiSatuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'sat_lv_1',
        'jlh_lv_1',
        'sat_lv_2',
        'jlh_lv_2',
        'sat_lv_3',
        'jlh_lv_3',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function satuan_1()
    {
        return $this->belongsTo(Satuan::class, 'sat_lv_1', 'id');
    }

    public function satuan_2()
    {
        return $this->belongsTo(Satuan::class, 'sat_lv_2', 'id');
    }

    public function satuan_3()
    {
        return $this->belongsTo(Satuan::class, 'sat_lv_3', 'id');
    }
}
