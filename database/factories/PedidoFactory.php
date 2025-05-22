<?php

namespace Database\Factories;

use App\Models\Pedido;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition()
    {
        return [
            'itens' => [],
            'subtotal' => 100.00,
            'frete' => 15.00,
            'total' => 115.00,
            'status' => 'pendente',
            'endereco' => [
                'cep' => '01001000',
                'logradouro' => 'Praça da Sé',
                'bairro' => 'Sé',
                'localidade' => 'São Paulo',
                'uf' => 'SP',
                'email' => 'cliente@teste.com',
            ],
        ];
    }
}
