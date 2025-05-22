<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstoqueController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:0',
            'variacao' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $estoque = Estoque::findOrFail($id);

            $estoque->update([
                'quantidade' => $request->quantidade,
                'variacao' => $request->variacao,
            ]);

            DB::commit();
            return response()->json($estoque);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao atualizar estoque'], 500);
        }
    }

    public function show($id)
    {
        $estoque = Estoque::findOrFail($id);
        return response()->json($estoque);
    }

    public function verificarDisponibilidade($produtoId, $quantidade, $variacao = null)
    {
        $estoque = Estoque::where('produto_id', $produtoId)
            ->where(function ($query) use ($variacao) {
                if ($variacao) {
                    $query->where('variacao', json_encode($variacao));
                }
            })->first();

        if (!$estoque || $estoque->quantidade < $quantidade) {
            return response()->json(['disponivel' => false], 200);
        }

        return response()->json(['disponivel' => true], 200);
    }
}
