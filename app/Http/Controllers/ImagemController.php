<?php

namespace App\Http\Controllers;

use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagemController extends Controller
{
    /**
     * Display a listing of the images.
     */
    public function index()
    {
        $imagens = Imagem::latest()->paginate(20);
        return view('croppen.imagens.imagens', compact('imagens'));
    }

    /**
     * Show the form for creating a new image.
     */
    public function create()
    {
        return view('imagens.create');
    }

    /**
     * Store a newly created image in storage.
     */
    public function store(Request $request)
    {
        dd($request->all(), $request->hasFile('imagem'));
        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            
            // Gerar nome único para o arquivo
            $nomeOriginal = $file->getClientOriginalName();
            $extensao = $file->getClientOriginalExtension();
            $nomeArquivo = time() . '_' . uniqid() . '.' . $extensao;
            
            // Salvar no storage/app/public/imagens
            $caminho = $file->storeAs('imagens', $nomeArquivo, 'public');
            
            // Criar registro no banco
            $imagem = Imagem::create([
                'nome_original' => $nomeOriginal,
                'nome_arquivo' => $nomeArquivo,
                'caminho' => $caminho,
                'extensao' => $extensao,
                'tamanho' => $file->getSize(),
                'localizacao' => $request->localizacao,
                'protocolo' => $request->protocolo,
                'cidade' => $request->cidade,
                'cultura' => $request->cultura,
                'doenca'=> $request->doenca
                
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Imagem enviada com sucesso!',
                'data' => $imagem
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Nenhuma imagem enviada.'
        ], 400);
    }

    /**
     * Display the specified image.
     */
    public function show($id)
    {
        $imagem = Imagem::findOrFail($id);
        
        if (!$imagem->arquivoExiste()) {
            return response()->json([
                'success' => false,
                'message' => 'Arquivo não encontrado no storage.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $imagem->id,
                'url' => $imagem->url,
                'nome_original' => $imagem->nome_original,
                'localizacao' => $imagem->localizacao,
                'protocolo' => $imagem->protocolo,
            ]
        ]);
    }

    /**
     * Remove the specified image from storage.
     */
    public function destroy($id)
    {
        $imagem = Imagem::findOrFail($id);
        
        // Deletar arquivo do storage
        if ($imagem->arquivoExiste()) {
            Storage::disk('public')->delete($imagem->caminho);
        }
        
        // Deletar registro do banco
        $imagem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Imagem removida com sucesso!'
        ]);
    }

    /**
     * Método para upload múltiplo
     */
    public function uploadMultiplo(Request $request)
    {
        $request->validate([
            'imagens.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'localizacao' => 'nullable|string|max:255',
            'protocolo' => 'nullable|string|max:100',
        ]);

        $imagensSalvas = [];

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $file) {
                $nomeOriginal = $file->getClientOriginalName();
                $extensao = $file->getClientOriginalExtension();
                $nomeArquivo = time() . '_' . uniqid() . '.' . $extensao;
                
                $caminho = $file->storeAs('imagens', $nomeArquivo, 'public');
                
                $imagem = Imagem::create([
                    'nome_original' => $nomeOriginal,
                    'nome_arquivo' => $nomeArquivo,
                    'caminho' => $caminho,
                    'extensao' => $extensao,
                    'tamanho' => $file->getSize(),
                    'localizacao' => $request->localizacao,
                    'protocolo' => $request->protocolo,
                    'amostra_id' => $request->amostra_id,
                    'resultado_id' => $request->resultado_id,
                    'ordem_id' => $request->ordem_id,
                ]);

                $imagensSalvas[] = $imagem;
            }

            return response()->json([
                'success' => true,
                'message' => count($imagensSalvas) . ' imagem(ns) enviada(s) com sucesso!',
                'data' => $imagensSalvas
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Nenhuma imagem enviada.'
        ], 400);
    }
}