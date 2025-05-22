<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\PedidoFinalizado;

class PedidoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'itens' => 'required|array',
            'endereco' => 'required|array',
            'endereco.cep' => 'required|string',
        ]);

        // Validação do CEP via ViaCEP
        $cep = preg_replace('/[^0-9]/', '', $request->endereco['cep']);
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        if ($response->failed() || isset($response->json()['erro'])) {
            return response()->json(['error' => 'CEP inválido'], 422);
        }

        $itens = $request->itens;
        $subtotal = 0;

        DB::beginTransaction();
        try {
            // Calcular subtotal e verificar estoque
            foreach ($itens as $item) {
                $estoque = Estoque::where('produto_id', $item['produto_id'])
                    ->where(function ($query) use ($item) {
                        if (isset($item['variacao'])) {
                            $query->where('variacao', json_encode($item['variacao']));
                        }
                    })->first();

                if (!$estoque || $estoque->quantidade < $item['quantidade']) {
                    DB::rollBack();
                    return response()->json(['error' => 'Estoque insuficiente para o produto ID ' . $item['produto_id']], 422);
                }

                $subtotal += $item['preco'] * $item['quantidade'];
            }

            // Calcular frete
            if ($subtotal >= 52 && $subtotal <= 166.59) {
                $frete = 15.00;
            } elseif ($subtotal > 200) {
                $frete = 0.00;
            } else {
                $frete = 20.00;
            }

            $total = $subtotal + $frete;

            // Criar pedido
            $pedido = Pedido::create([
                'itens' => $itens,
                'subtotal' => $subtotal,
                'frete' => $frete,
                'total' => $total,
                'status' => 'pendente',
                'endereco' => $request->endereco,
            ]);

            // Atualizar estoque
            foreach ($itens as $item) {
                $estoque = Estoque::where('produto_id', $item['produto_id'])
                    ->where(function ($query) use ($item) {
                        if (isset($item['variacao'])) {
                            $query->where('variacao', json_encode($item['variacao']));
                        }
                    })->first();

                $estoque->decrement('quantidade', $item['quantidade']);
            }

            DB::commit();

            // Enviar e-mail
            Mail::to($request->endereco['email'] ?? 'cliente@example.com')
                ->send(new PedidoFinalizado($pedido));

            return response()->json($pedido, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao criar pedido'], 500);
        }
    }

    public function webhook(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'status' => 'required|string',
        ]);

        $pedido = Pedido::findOrFail($request->id);

        if ($request->status === 'cancelado') {
            $pedido->delete();
            return response()->json(['message' => 'Pedido cancelado e removido']);
        } else {
            $pedido->status = $request->status;
            $pedido->save();
            return response()->json(['message' => 'Status do pedido atualizado']);
        }
    }
}
