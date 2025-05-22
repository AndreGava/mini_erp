<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use Illuminate\Http\Request;

class CupomController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|unique:cupons',
            'validade' => 'required|date',
            'valor_minimo' => 'required|numeric|min:0',
            'desconto' => 'required|numeric|min:0',
        ]);

        $cupom = Cupom::create([
            'codigo' => $request->codigo,
            'validade' => $request->validade,
            'valor_minimo' => $request->valor_minimo,
            'desconto' => $request->desconto,
        ]);

        return response()->json($cupom, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string|unique:cupons,codigo,' . $id,
            'validade' => 'required|date',
            'valor_minimo' => 'required|numeric|min:0',
            'desconto' => 'required|numeric|min:0',
        ]);

        $cupom = Cupom::findOrFail($id);

        $cupom->update([
            'codigo' => $request->codigo,
            'validade' => $request->validade,
            'valor_minimo' => $request->valor_minimo,
            'desconto' => $request->desconto,
        ]);

        return response()->json($cupom);
    }
}
