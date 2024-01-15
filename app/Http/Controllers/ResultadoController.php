<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resultado;
use App\Models\Nematoides;
use App\Models\NematoidesResultado;

class ResultadoController extends Controller
{
    public function index()
    {
        $resultados = Resultado::all();
        return view('croppen.resultados.resultados', compact('resultados'));
    }

    public function indexCadastro($id = null)
    {
        $resultados = $id ? Resultado::find($id) : new Resultado();
        $nema = Nematoides::all();
        $idsresult = $id ? NematoidesResultado::where('resultado_id', $id)->with('nematoides')->get() : [];
        
        return view('croppen.resultados.resultadosCadastro', compact('resultados','nema','idsresult'));
    }

    public function store(Request $request)

    {
        Resultado::create($request->all());

        return redirect()->route('resultados')->with('success', 'Resultado cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $resultados = Resultado::find($id);
        $resultados->update($request->all());
        return redirect()->route('resultados')->with('success', 'Resultado atualizado com sucesso!');
    }

    public function storeItem(Request $request)

    {
        $result = NematoidesResultado::create($request->all());

        // Obtém o orcamento_id recém-criado
        $id = $result->resultado_id;
        return redirect()->route('resultCadastro', ['id' => $id])->with('success', 'Registro excluído com sucesso!');
    }

    public function destroy($id)
    {
        $result = NematoidesResultado::findOrFail($id);
        $id = $result->resultado_id;
        $result->delete();

        return redirect()->route('resultCadastro', ['id' => $id])->with('success', 'Registro excluído com sucesso!');
    }

    public function relatorio($id = null)
    {
        $resultados = $id ? Resultado::find($id) : new Resultado();
        $nema = Nematoides::all();
        $idsresult = $id ? NematoidesResultado::where('resultado_id', $id)->with('nematoides')->get() : [];
        
        return view('croppen.resultados.relatorioresultado', compact('resultados','nema','idsresult'));
    }

}
