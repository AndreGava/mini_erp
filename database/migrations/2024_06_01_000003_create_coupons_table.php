<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->decimal('desconto', 10, 2);
            $table->decimal('valor_minimo', 10, 2)->default(0);
            $table->date('validade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cupons');
    }
}
