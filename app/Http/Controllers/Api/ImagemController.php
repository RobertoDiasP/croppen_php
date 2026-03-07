<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImagemController extends Controller
{
    /**
     * Listar todas as imagens
     * GET /api/imagens
     */
    public function index()
    {
        $imagens = Imagem::latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $imagens
        ]);
    }

    /**
     * Upload de uma única imagem
     * POST /api/imagens
     */
    public function store(Request $request)
    {

        try {
            if ($request->hasFile('imagem')) {
                $file = $request->file('imagem');

                // Gerar nome único
                $nomeOriginal = $file->getClientOriginalName();
                $extensao = $file->getClientOriginalExtension();
                $nomeArquivo = time() . '_' . uniqid() . '.' . $extensao;

                // Salvar no storage
                $caminho = $file->storeAs('imagens', $nomeArquivo, 'public');

                // Criar registro
                $imagem = Imagem::create([
                    'nome_original' => $nomeOriginal,
                    'nome_arquivo' => $nomeArquivo,
                    'caminho' => $caminho,
                    'extensao' => $extensao,
                    'tamanho' => $file->getSize(),
                    'localizacao' => $request->localizacao,
                    'protocolo' => $request->protocolo,
                    'protocolo' => $request->protocolo,
                    'cidade' => $request->cidade,
                    'cultura' => $request->cultura,
                    'doenca' => $request->doenca

                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Imagem enviada com sucesso!',
                    'data' => [
                        'id' => $imagem->id,
                        'url' => asset('storage/' . $caminho),
                        'nome_original' => $imagem->nome_original,
                        'localizacao' => $imagem->localizacao,
                        'protocolo' => $imagem->protocolo,
                        'caminho' => $caminho
                    ]
                ], 201);
            }

            return response()->json([
                'success' => false,
                'message' => 'Nenhuma imagem enviada.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer upload: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload múltiplo de imagens
     * POST /api/imagens/upload-multiplo
     */
    public function uploadMultiplo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imagens' => 'required|array|min:1|max:10',
            'imagens.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',

            'localizacao' => 'nullable|string|max:255',
            'protocolo' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:255',
            'cultura' => 'nullable|string|max:255',
            'doenca' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $imagensSalvas = [];

            // Dados comuns a todas as imagens
            $dadosComuns = [
                'localizacao' => $request->localizacao,
                'protocolo' => $request->protocolo,
                'cidade' => $request->cidade,
                'cultura' => $request->cultura,
                'doenca' => $request->doenca,
            ];

            foreach ($request->file('imagens') as $file) {

                $nomeOriginal = $file->getClientOriginalName();
                $extensao = $file->getClientOriginalExtension();
                $nomeArquivo = time() . '_' . uniqid() . '.' . $extensao;

                $caminho = $file->storeAs('imagens', $nomeArquivo, 'public');

                $imagem = Imagem::create(array_merge([
                    'nome_original' => $nomeOriginal,
                    'nome_arquivo' => $nomeArquivo,
                    'caminho' => $caminho,
                    'extensao' => $extensao,
                    'tamanho' => $file->getSize(),
                ], $dadosComuns));

                $imagensSalvas[] = [
                    'id' => $imagem->id,
                    'url' => asset('storage/' . $caminho),
                    'nome_original' => $imagem->nome_original,
                    'localizacao' => $imagem->localizacao,
                    'protocolo' => $imagem->protocolo,
                    'cidade' => $imagem->cidade,
                    'cultura' => $imagem->cultura,
                    'doenca' => $imagem->doenca,
                ];
            }

            return response()->json([
                'success' => true,
                'message' => count($imagensSalvas) . ' imagem(ns) enviada(s) com sucesso!',
                'data' => $imagensSalvas
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer upload: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibir uma imagem específica
     * GET /api/imagens/{id}
     */
    public function show($id)
    {
        try {
            $imagem = Imagem::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $imagem->id,
                    'url' => asset('storage/' . $imagem->caminho),
                    'nome_original' => $imagem->nome_original,
                    'localizacao' => $imagem->localizacao,
                    'protocolo' => $imagem->protocolo,
                    'tamanho' => $imagem->tamanho,
                    'extensao' => $imagem->extensao,
                    'created_at' => $imagem->created_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Imagem não encontrada'
            ], 404);
        }
    }

    /**
     * Deletar uma imagem
     * DELETE /api/imagens/{id}
     */
    public function destroy($id)
    {
        try {
            $imagem = Imagem::findOrFail($id);

            // Deletar arquivo físico
            if (Storage::disk('public')->exists($imagem->caminho)) {
                Storage::disk('public')->delete($imagem->caminho);
            }

            // Deletar registro
            $imagem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Imagem removida com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover imagem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar imagens por protocolo
     * GET /api/imagens/protocolo/{protocolo}
     */
    public function buscarPorProtocolo($protocolo)
    {
        $imagens = Imagem::where('protocolo', 'LIKE', "%{$protocolo}%")->get();

        return response()->json([
            'success' => true,
            'data' => $imagens
        ]);
    }

    /**
     * Buscar imagens por localização
     * GET /api/imagens/localizacao/{localizacao}
     */
    public function buscarPorLocalizacao($localizacao)
    {
        $imagens = Imagem::where('localizacao', 'LIKE', "%{$localizacao}%")->get();

        return response()->json([
            'success' => true,
            'data' => $imagens
        ]);
    }

    /**
     * Atualizar dados da imagem
     * PUT /api/imagens/{id}
     */
    public function update(Request $request, $id)
    {
        try {

            $imagem = Imagem::findOrFail($id);

            $imagem->update([
                'cultura' => $request->cultura,
                'doenca' => $request->doenca,
                'cidade' => $request->cidade
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Imagem atualizada com sucesso!',
                'data' => $imagem
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar imagem: ' . $e->getMessage()
            ], 500);
        }
    }
}
