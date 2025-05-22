<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\PedidoController;

// Test route
// Como bootstrap/app.php adiciona o prefixo 'api', esta rota será acessível em /api/test
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

// Produtos
// Ex: /api/produtos
Route::post('/produtos', [ProdutoController::class, 'store']);
Route::put('/produtos/{id}', [ProdutoController::class, 'update']);

// Estoque
// Ex: /api/estoques/{id}
Route::put('/estoques/{id}', [EstoqueController::class, 'update']);
Route::get('/estoques/{id}', [EstoqueController::class, 'show']);
Route::get('/estoques/verificar/{produtoId}', [EstoqueController::class, 'verificarDisponibilidade']);

// Cupons
// Ex: /api/cupons
Route::post('/cupons', [CupomController::class, 'store']);
Route::put('/cupons/{id}', [CupomController::class, 'update']);

// Pedidos
// Ex: /api/pedidos
Route::post('/pedidos', [PedidoController::class, 'store']);
Route::post('/pedidos/webhook', [PedidoController::class, 'webhook']);

?>
