<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trecho extends Model
{
    use HasFactory;

    protected $table = 'trechos';

    protected $fillable = [
        'data_referencia',
        'uf_id',
        'rodovia_id',
        'tipo',
        'km_inicial',
        'km_final',
        'geo',
    ];

    protected $casts = [
        'geo' => 'json',
    ];

    public function uf()
    {
        return $this->belongsTo(Uf::class, 'uf_id');

    }

    public function rodovia()
    {
        return $this->belongsTo(Rodovia::class, 'rodovia_id');

    }
}
