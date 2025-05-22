<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Estoque;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_pedido()
    {
        $produto = Produto::factory()->create([
            'nome' => 'Produto Teste',
            'preco' => 100.00,
            'variacoes' => null,
        ]);

        Estoque::create([
            'produto_id' => $produto->id,
            'quantidade' => 10,
            'variacao' => null,
        ]);

        $data = [
            'itens' => [
                [
                    'produto_id' => $produto->id,
                    'quantidade' => 2,
                    'preco' => 100.00,
                ],
            ],
            'endereco' => [
                'cep' => '01001000',
                'logradouro' => 'Praça da Sé',
                'bairro' => 'Sé',
                'localidade' => 'São Paulo',
                'uf' => 'SP',
            ],
        ];

        $response = $this->postJson('/api/pedidos', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['status' => 'pendente']);
        $this->assertDatabaseHas('pedidos', ['status' => 'pendente']);
    }

    public function test_webhook_cancel_pedido()
    {
        $pedido = Pedido::factory()->create([
            'status' => 'pendente',
        ]);

        $data = [
            'id' => $pedido->id,
            'status' => 'cancelado',
        ];

        $response = $this->postJson('/api/pedidos/webhook', $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Pedido cancelado e removido']);
        $this->assertDatabaseMissing('pedidos', ['id' => $pedido->id]);
    }

    public function test_webhook_update_status()
    {
        $pedido = Pedido::factory()->create([
            'status' => 'pendente',
        ]);

        $data = [
            'id' => $pedido->id,
            'status' => 'enviado',
        ];

        $response = $this->postJson('/api/pedidos/webhook', $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Status do pedido atualizado']);
        $this->assertDatabaseHas('pedidos', ['id' => $pedido->id, 'status' => 'enviado']);
    }
}
