<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\CarrinhoService;

class CarrinhoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_adicionar_item_ao_carrinho()
    {
        $carrinhoService = new CarrinhoService();

        $carrinhoService->adicionarItem(1, 2, 50.00);
        $carrinhoService->adicionarItem(1, 1, 50.00);

        $subtotal = $carrinhoService->calcularSubtotal();
        $frete = $carrinhoService->calcularFrete();
        $total = $carrinhoService->calcularTotal();

        $this->assertEquals(150.00, $subtotal);
        $this->assertEquals(15.00, $frete);
        $this->assertEquals(165.00, $total);
    }

    public function test_remover_item_do_carrinho()
    {
        $carrinhoService = new CarrinhoService();

        $carrinhoService->adicionarItem(1, 2, 50.00);
        $carrinhoService->removerItem(1);

        $subtotal = $carrinhoService->calcularSubtotal();
        $frete = $carrinhoService->calcularFrete();
        $total = $carrinhoService->calcularTotal();

        $this->assertEquals(0, $subtotal);
        $this->assertEquals(20.00, $frete);
        $this->assertEquals(20.00, $total);
    }
}
