<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    protected $fillable = [
        'nome'
    ];

    public function imagens()
    {
        return $this->belongsToMany(
            Imagem::class,
            'lista_agentes',
            'agente_id',
            'imagem_id'
        );
    }
}
