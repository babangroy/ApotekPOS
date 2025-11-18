<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Margin extends Model
{
    use HasFactory;

    protected $fillable = [
        'costumer_id', 'margin'
    ];

    public function costumer(){
        return $this->belongsTo(Costumer::class);
    }
}
