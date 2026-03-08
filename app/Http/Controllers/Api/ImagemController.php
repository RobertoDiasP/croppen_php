<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Imagem;
use App\Models\Agente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImagemController extends Controller
{

    /**
     * Listar imagens
     */
    public function index(Request $request)
    {
        $query = Imagem::with('agentes');

        if ($request->id) {
            $query->where('id', $request->id);
        }

        if ($request->cultura) {
            $query->where('cultura', 'like', '%' . $request->cultura . '%');
        }

        if ($request->doenca) {
            $query->where('doenca', 'like', '%' . $request->doenca . '%');
        }

        if ($request->cidade) {
            $query->where('cidade', 'like', '%' . $request->cidade . '%');
        }

        if ($request->agente) {

            $query->whereHas('agentes', function ($q) use ($request) {
                $q->where('agentes.id', $request->agente);
            });
        }

        $query->orderBy('id', 'desc');
        return $query->paginate(30);
    }
    public function storeAgente(Request $request)
    {

        $agente = Agente::create([
            'nome' => $request->nome
        ]);

        return $agente;
    }

    /**
     * Upload de uma imagem
     */
    public function store(Request $request)
    {
        try {

            if ($request->hasFile('imagem')) {

                $file = $request->file('imagem');

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
                    'cidade' => $request->cidade,
                    'cultura' => $request->cultura,
                    'doenca' => $request->doenca
                ]);

                /**
                 * salvar agentes
                 */
                if ($request->has('agentes')) {
                    $imagem->agentes()->sync($request->agentes);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Imagem enviada com sucesso!',
                    'data' => $imagem->load('agentes')
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
     * Upload múltiplo
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
            'agentes' => 'nullable|array'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $imagensSalvas = [];

            $dadosComuns = [
                'localizacao' => $request->localizacao,
                'protocolo' => $request->protocolo,
                'cidade' => $request->cidade,
                'cultura' => $request->cultura,
                'doenca' => $request->doenca
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
                    'tamanho' => $file->getSize()
                ], $dadosComuns));

                /**
                 * salvar agentes
                 */
                if ($request->has('agentes')) {
                    $imagem->agentes()->sync($request->agentes);
                }

                $imagensSalvas[] = $imagem->load('agentes');
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
     * Mostrar imagem
     */
    public function show($id)
    {
        try {

            $imagem = Imagem::with('agentes')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $imagem
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Imagem não encontrada'
            ], 404);
        }
    }


    /**
     * Atualizar imagem
     */
    public function update(Request $request, $id)
    {
        try {

            $imagem = Imagem::findOrFail($id);

            $imagem->update([
                'cidade' => $request->cidade,
                'cultura' => $request->cultura,
                'doenca' => $request->doenca,
                'localizacao' => $request->localizacao,
                'protocolo' => $request->protocolo
            ]);

            /**
             * atualizar agentes
             */
            if ($request->has('agentes')) {
                $imagem->agentes()->sync($request->agentes);
            }

            return response()->json([
                'success' => true,
                'message' => 'Imagem atualizada com sucesso!',
                'data' => $imagem->load('agentes')
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar imagem: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Deletar imagem
     */
    public function destroy($id)
    {
        try {

            $imagem = Imagem::findOrFail($id);

            /**
             * remover agentes vinculados
             */
            $imagem->agentes()->detach();

            if (Storage::disk('public')->exists($imagem->caminho)) {
                Storage::disk('public')->delete($imagem->caminho);
            }

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

    public function listarAgentes()
    {
        try {

            $agentes = \App\Models\Agente::orderBy('nome')->get();

            return response()->json([
                'success' => true,
                'data' => $agentes
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar agentes: ' . $e->getMessage()
            ], 500);
        }
    }
    public function adicionarAgentes(Request $request, $id)
    {
        try {

            $imagem = Imagem::findOrFail($id);

            if (!$request->agentes) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhum agente informado'
                ], 400);
            }

            // adiciona agentes sem remover os existentes
            $imagem->agentes()->syncWithoutDetaching($request->agentes);

            return response()->json([
                'success' => true,
                'message' => 'Agentes adicionados à imagem',
                'data' => $imagem->load('agentes')
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro ao adicionar agentes: ' . $e->getMessage()
            ], 500);
        }
    }
}
