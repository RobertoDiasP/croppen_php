<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServico extends Model
{
    use HasFactory;
    protected $fillable = [
        "tipo", "status", "descricao","data"
    ];

    public function amostras()
    {
        return $this->hasMany(Amostra::class);
    }
    
    public function resultados()
    {
        return $this->hasMany(Resultado::class, 'ordem_id');
    }
}
