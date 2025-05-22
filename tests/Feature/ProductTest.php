<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Produto;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product()
    {
        $data = [
            'nome' => 'Produto Teste',
            'preco' => 100.00,
            'variacoes' => [ // Enviar como um array PHP
                [
                    'nome_variacao' => 'Cor', // Exemplo de nome para o tipo de variação
                    'valor_variacao' => 'Azul', // Exemplo de valor da variação
                    'quantidade_estoque_variacao' => 10 // Exemplo de estoque para esta variação específica
                ],
                [
                    'nome_variacao' => 'Tamanho',
                    'valor_variacao' => 'M',
                    'quantidade_estoque_variacao' => 5
                ]
            ],
            'quantidade' => 15, // Adicionar o campo quantidade obrigatório (total ou do produto principal)
        ];

        $response = $this->postJson('/api/produtos', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['nome' => 'Produto Teste']);
        $this->assertDatabaseHas('produtos', ['nome' => 'Produto Teste']);
        // Seria bom adicionar asserções para verificar se as variações e os estoques
        // foram criados corretamente no banco de dados.
    }


    public function test_update_product()
    {
        $produto = Produto::factory()->create();

        $data = [
            'nome' => 'Produto Atualizado',
            'preco' => 150.00,
        ];

        $response = $this->putJson("/api/produtos/{$produto->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Produto Atualizado']);
        $this->assertDatabaseHas('produtos', ['nome' => 'Produto Atualizado']);
    }
}
