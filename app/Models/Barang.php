<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'barcode',
        'nama',
        'jenis_id',
        'kategori_id',
        'merek_id',
        'pabrikan_id',
        'satuan_id',
    ];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function pabrikan()
    {
        return $this->belongsTo(Pabrikan::class);
    }

    public function konversis()
    {
        return $this->hasMany(Konversi::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'barang_id');
    }

    protected static function booted()
    {
        static::created(function (Barang $barang) {
            if (!$barang->kode) {
                $barang->kode = 'BRG-' . str_pad($barang->id, 5, '0', STR_PAD_LEFT);
                $barang->save();
            }
        });
    }
}
