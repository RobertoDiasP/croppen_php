<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orcamento;
use App\Models\Empresas;
use App\Models\Orcamentoid;

class OrcaController extends Controller
{
    public function index()
    {
        $orca = Orcamento::all();
        return view('croppen.cadastros.orcamento',  compact('orca'));
    }

    public function indexCadastro($id = null)
    {
        $orca = $id ? Orcamento::find($id) : new Orcamento();
        $orcaitem = $id ? Orcamentoid::where('orcamento_id', $id)->get() : collect();

        // Inicializa a variável $totalValorId
        $totalValorId = 0;

        // Loop através dos itens para calcular a soma
        foreach ($orcaitem as $iten) {
            $totalValorId += $iten->valor;
        }

        // Passa a variável $totalValorId para a view
        return view('croppen.cadastros.orcamentoCadastro', compact('orca', 'orcaitem', 'totalValorId'));
    }

    public function store(Request $request)

    {
        Orcamento::create($request->all());

        return redirect()->route('orca')->with('success', 'Ordem cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $orca = Orcamento::find($id);
        $orca->update($request->all());
        return redirect()->route('orca')->with('success', 'Empresa atualizado com sucesso!');
    }

    public function indexIdOrca()
    {
        $orca = Orcamento::all();
        return view('croppen.cadastros.orcamento',  compact('orca'));
    }

    public function storeOrcaId(Request $request)
    {
        $orcamentoid = Orcamentoid::create($request->all());

        // Obtém o orcamento_id recém-criado
        $orcamentoId = $orcamentoid->orcamento_id;

        return redirect()->route('orcaCadastro', ['id' => $orcamentoId])->with('success', 'Ordem cadastrada com sucesso!');
    }
    
    public function destroy($id)
    {
        $orcamentoid = Orcamentoid::findOrFail($id);
        $id = $orcamentoid->orcamento_id;
        $orcamentoid->delete();

        return redirect()->route('orcaCadastro', ['id' => $id])->with('success', 'Registro excluído com sucesso!');
    }

}
