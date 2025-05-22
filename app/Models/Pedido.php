<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'itens',
        'subtotal',
        'frete',
        'total',
        'status',
        'endereco',
        'cupom_id',
    ];

    protected $casts = [
        'itens' => 'array',
        'endereco' => 'array',
        'subtotal' => 'float',
        'frete' => 'float',
        'total' => 'float',
    ];

    public function cupom()
    {
        return $this->belongsTo(Cupom::class);
    }

    public function calcularFrete()
    {
        if ($this->subtotal >= 52 && $this->subtotal <= 166.59) {
            return 15.00;
        } elseif ($this->subtotal > 200) {
            return 0.00;
        }
        return 20.00;
    }

    public function aplicarCupom(Cupom $cupom)
    {
        if ($cupom->isValido($this->subtotal)) {
            $this->cupom_id = $cupom->id;
            $this->subtotal = $cupom->aplicarDesconto($this->subtotal);
            $this->frete = $this->calcularFrete();
            $this->total = $this->subtotal + $this->frete;
            return true;
        }
        return false;
    }
}
