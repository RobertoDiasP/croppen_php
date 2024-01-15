<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NematoidesResultado extends Model
{
    protected $table = 'nematoides_resultado';

    protected $fillable = ['resultado_id', 'nematode_id', 'quantidade'];

    public function resultado()
    {
        return $this->belongsTo(Resultado::class);
    }

    public function nematoides()
    {
        return $this->belongsTo(Nematoides::class, 'nematode_id');
    }
}
