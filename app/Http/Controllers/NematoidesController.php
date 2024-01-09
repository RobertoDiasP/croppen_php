<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nematoides;


class NematoidesController extends Controller
{
    public function index()
    {
        $nema = Nematoides::all();
        return view('croppen.cadastros.nematoides', compact('nema'));
    }

    public function indexCadastro($id = null)
    {
        $nema = $id ? Nematoides::find($id) : new Nematoides();
        
        return view('croppen.cadastros.nematoidesCadastro', compact('nema'));
    }

    public function store(Request $request)

    {
        Nematoides::create($request->all());

        return redirect()->route('namatoides')->with('success', 'Empresa cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $amostras = Nematoides::find($id);
        $amostras->update($request->all());
        return redirect()->route('namatoides')->with('success', 'Empresa atualizado com sucesso!');
    }
}
