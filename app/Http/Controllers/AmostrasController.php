<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amostras;

class AmostrasController extends Controller
{
    /**
     * 
     */
        public function index()
    {
        $amostras = Amostras::all();
        return view('croppen.cadastros.amostras', compact('amostras'));
    }

    /**
     * 
     */
    public function indexList(Request $request)
    {
        
        
        $query = Amostras::with('ordemServico'); // Carregue os dados relacionados da tabela ordem_servico

        // Aplicar filtros, se fornecidos
        if ($request->has('id_interno')) {
            $query->where('id_interno', 'like', '%' . $request->input('id_interno') . '%');
        }
        
        
        if ($request->has('data_inicio') && $request->has('data_fim')) {
            $data_inicio = $request->input('data_inicio');
            $data_fim = $request->input('data_fim');
            
            // Aplicar filtro de data somente se ambas as datas estiverem presentes
            $query->whereBetween('data_amostra', [$data_inicio, $data_fim]);
        }
    
        if ($request->has('id_externo')) {
            $query->where('id_externo', 'like', '%' . $request->input('id_externo') . '%');
        }
    
        if ($request->has('cultura')) {
            $query->where('cultura', 'like', '%' . $request->input('cultura') . '%');
        }
       
        // Outros filtros...
    
        $amostras = $query->get();
    
        return view('croppen.listaAmostras', compact('amostras'));
    }

    /**
     * 
     */
    public function store(Request $request)
    {
        // Valide os dados do formulário
        // $request->validate([
        //     'nome' => 'required|string|max:255',
        //     'email' => 'required|email|unique:usuarios',
        //     // Adicione mais regras de validação conforme necessário
        // ]);

        // Salve os dados no banco de dados
        // Substitua 'Usuario' pelo nome do seu modelo
        Amostras::create([
            'id_interno' => $request->input('id_interno'),
            'id_externo' => $request->input('id_externo'),
            'id_cadastro' => $request->input('id_cadastro'),
            'cultura' => $request->input('cultura'),
            'propriedade' => $request->input('propriedade'),
            'tipo' => $request->input('tipo'),
            'lote' => $request->input('lote'),
            'status' => $request->input('status'),
            // Defina outros campos conforme necessário
        ]);
        // Redirecione para uma página de confirmação ou outra página
        return redirect('/cadastros/amostras')->with('success', 'Cadastro realizado com sucesso!');
    }
}
