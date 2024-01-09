<?php

namespace App\Imports;

use App\Models\Amostras;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use Carbon\Carbon;

class OrdemServicoImport implements ToModel
{
    private $startRow = 3;
    private $idOrdem;

    public function __construct($idOrdem)
    {
        $this->idOrdem = $idOrdem;
    }

    public function model(array $row)
    {
         // Ignora as linhas antes da linha inicial desejada
         if ($this->startRow > 1) {
            $this->startRow--;
            return null;
        }

        if (empty($row[0])) {
            return null; // Retorna null para indicar que a importação deve ser interrompida
        }

        return new Amostras([
            'id_interno' => $row[0],
            'cultura' => $row[7],
            'propriedade' => $row[5],
            'solicitantes' => $row[3],
            'descricao' => $row[6],
            'data_amostra' =>$row[2],
            'ordem_servico_id' => $this->idOrdem,
            // Outros campos...
        ]);
    }
    
}