<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Estoque;
use App\Models\Produto;

class EstoqueTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_estoque()
    {
        $produto = Produto::factory()->create();

        $estoque = Estoque::create([
            'produto_id' => $produto->id,
            'quantidade' => 10,
            'variacao' => null,
        ]);

        $data = [
            'quantidade' => 20,
            'variacao' => ['cor' => 'azul'],
        ];

        $response = $this->putJson("/api/estoques/{$estoque->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['quantidade' => 20]);
        $this->assertDatabaseHas('estoques', ['id' => $estoque->id, 'quantidade' => 20]);
    }
}
