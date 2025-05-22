<?php

namespace App\Services;

use App\Models\Estoque;
use Illuminate\Support\Facades\Session;

class CarrinhoService
{
    public function adicionarItem($produtoId, $quantidade, $preco, $variacao = null)
    {
        $carrinho = Session::get('carrinho', []);

        $key = $this->gerarChave($produtoId, $variacao);

        if (isset($carrinho[$key])) {
            $carrinho[$key]['quantidade'] += $quantidade;
        } else {
            $carrinho[$key] = [
                'produto_id' => $produtoId,
                'quantidade' => $quantidade,
                'preco' => $preco,
                'variacao' => $variacao,
            ];
        }

        Session::put('carrinho', $carrinho);
    }

    public function removerItem($produtoId, $variacao = null)
    {
        $carrinho = Session::get('carrinho', []);

        $key = $this->gerarChave($produtoId, $variacao);

        if (isset($carrinho[$key])) {
            unset($carrinho[$key]);
            Session::put('carrinho', $carrinho);
        }
    }

    public function calcularSubtotal()
    {
        $carrinho = Session::get('carrinho', []);
        $subtotal = 0;

        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        return $subtotal;
    }

    public function calcularFrete()
    {
        $subtotal = $this->calcularSubtotal();

        if ($subtotal >= 52 && $subtotal <= 166.59) {
            return 15.00;
        } elseif ($subtotal > 200) {
            return 0.00;
        } else {
            return 20.00;
        }
    }

    public function calcularTotal()
    {
        return $this->calcularSubtotal() + $this->calcularFrete();
    }

    private function gerarChave($produtoId, $variacao)
    {
        if ($variacao) {
            return $produtoId . '_' . md5(json_encode($variacao));
        }
        return (string)$produtoId;
    }
}
