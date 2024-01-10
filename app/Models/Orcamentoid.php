<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamentoid extends Model
{
    use HasFactory;
    protected $table = 'orcamentoid';
    protected $fillable = ['orcamento_id','valor','descricao'];
    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class, 'orcamento_id');
    }

}
