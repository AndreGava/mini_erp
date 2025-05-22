<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->json('itens');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('frete', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pendente');
            $table->json('endereco');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
