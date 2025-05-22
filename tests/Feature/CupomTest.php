<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cupom;

class CupomTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_cupom()
    {
        $data = [
            'codigo' => 'CUPOM10',
            'desconto' => 10.00,
            'valor_minimo' => 50.00,
            'validade' => '2024-12-31',
        ];

        $response = $this->postJson('/api/cupons', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['codigo' => 'CUPOM10']);
        $this->assertDatabaseHas('cupons', ['codigo' => 'CUPOM10']);
    }

    public function test_update_cupom()
    {
        // Cria um cupom inicial usando a factory
        $cupom = Cupom::factory()->create([
            'codigo' => 'TESTE123',
            'desconto' => 10.00,
            'valor_minimo' => 50.00,
            'validade' => '2024-12-31',
        ]);

        // Dados para a atualização. Todos os campos obrigatórios devem ser fornecidos.
        $data = [
            'codigo' => 'ATUALIZADO456', // Novo código
            'desconto' => 15.00,         // Novo desconto (o que você quer testar)
            'valor_minimo' => 75.00,     // Novo valor mínimo
            'validade' => '2025-12-31',   // Nova validade
        ];

        $response = $this->putJson("/api/cupons/{$cupom->id}", $data);

        // Verifica se o status é 200 (OK)
        $response->assertStatus(200)
                 // Verifica se o JSON de resposta contém o novo desconto
                 ->assertJsonFragment(['desconto' => 15.00]);

        // Verifica se o banco de dados foi atualizado com todos os novos dados
        $this->assertDatabaseHas('cupons', [
            'id' => $cupom->id, // Garante que estamos verificando o cupom correto
            'codigo' => 'ATUALIZADO456',
            'desconto' => 15, // Ajustado para corresponder ao formato do banco (inteiro)
            'valor_minimo' => 75, // Ajustado para corresponder ao formato do banco (inteiro)
            'validade' => '2025-12-31 00:00:00', // Ajustado para incluir a hora
        ]);
    }


}
