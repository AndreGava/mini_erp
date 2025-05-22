<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\PedidoFinalizado;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Estoque;

class PedidoEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_enviado_ao_finalizar_pedido()
    {
        Mail::fake();

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
                'email' => 'cliente@teste.com',
            ],
        ];

        $this->postJson('/api/pedidos', $data);

        Mail::assertSent(PedidoFinalizado::class, function ($mail) use ($data) {
            return $mail->hasTo('cliente@teste.com');
        });
    }
}
