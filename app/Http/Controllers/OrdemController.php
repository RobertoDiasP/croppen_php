<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdemServico;
use App\Models\Amostras;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OrdemServicoImport;

class OrdemController extends Controller
{
    public function index()
    {
        $ordem = OrdemServico::all();
        return view('croppen.cadastros.ordem', compact('ordem'));
    }

    public function indexCadastro($id = null)
    {
        $ordem = $id ? OrdemServico::find($id) : new OrdemServico();
        $amostras = $id ? Amostras::where('ordem_servico_id', $id)->get() : collect();

        return view('croppen.cadastros.ordemCadastro', compact('ordem','amostras'));
    }

    public function store(Request $request)

    {
        OrdemServico::create($request->all());

        return redirect()->route('ordem')->with('success', 'Ordem cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $ordem = OrdemServico::find($id);
        $ordem->update($request->all());
        return redirect()->route('ordem')->with('success', 'Empresa atualizado com sucesso!');
    }

    public function import(Request $request, $idOrdem)
    {
        ini_set('max_execution_time', 280); // Ajuste o valor conforme necessário
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        Excel::import(new OrdemServicoImport($idOrdem), $file);
        

        return redirect()->back()->with('success', 'Dados importados com sucesso.');
    }

    public function indexCadastroAmostraOrdem($id)
    {
        $ordemId = $id ;
        
        return view('croppen.cadastros.amostraOrdem', compact('ordemId'));
    }

    

}
