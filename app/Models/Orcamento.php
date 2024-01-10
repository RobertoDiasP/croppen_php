<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;
    protected $table = 'orcamento';
    protected $fillable = ['cliente_id', 'valor', 'desconto', 'descricao'];
    
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'cliente_id');
    }
    public function orcamentoid()
    {
        return $this->hasOne(Orcamentoid::class, 'orcamento_id');
    }
}
