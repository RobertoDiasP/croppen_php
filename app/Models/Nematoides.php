<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nematoides extends Model
{
    protected $fillable = ['genero', 'especie'];

    public function resultadosid()
    {
        return $this->hasMany(NematoidesResultado::class, 'nematode_id');
    }

    public function resultados()
    {
        return $this->belongsToMany(Resultado::class, 'nematoides_resultado')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
}
