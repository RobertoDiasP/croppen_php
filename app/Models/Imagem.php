<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Imagem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome_original',
        'nome_arquivo',
        'caminho',
        'extensao',
        'tamanho',
        'localizacao',
        'protocolo',
        'cidade',
        'cultura',
        'doenca'
    ];





    /**
     * Acessor para URL da imagem
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->caminho);
    }

    /**
     * Verifica se o arquivo existe
     */
    public function arquivoExiste()
    {
        return Storage::disk('public')->exists($this->caminho);
    }
}
