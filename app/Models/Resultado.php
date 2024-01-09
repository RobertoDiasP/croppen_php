<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $fillable = ['amostra_id'];

    public function amostra()
    {
        return $this->belongsTo(Amostra::class);
    }

    public function nematoides()
    {
        return $this->belongsToMany(Nematode::class, 'nematoides_resultado')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
}
