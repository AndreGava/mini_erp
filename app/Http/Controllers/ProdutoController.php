<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'variacoes' => 'nullable|array',
            'quantidade' => 'required|integer|min:0'
        ]);

        DB::beginTransaction();
        try {
            $produto = Produto::create([
                'nome' => $request->nome,
                'preco' => $request->preco,
                'variacoes' => $request->variacoes,
            ]);

            Estoque::create([
                'produto_id' => $produto->id,
                'quantidade' => $request->quantidade,
                'variacao' => null,
            ]);

            DB::commit();
            return response()->json($produto, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao criar produto'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'variacoes' => 'nullable|array',
        ]);

        $produto = Produto::findOrFail($id);

        $produto->update([
            'nome' => $request->nome,
            'preco' => $request->preco,
            'variacoes' => $request->variacoes,
        ]);

        return response()->json($produto);
    }
}
