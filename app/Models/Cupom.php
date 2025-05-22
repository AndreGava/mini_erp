<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    use HasFactory;

    protected $table = 'cupons';

    protected $fillable = [
        'codigo',
        'validade',
        'valor_minimo',
        'desconto',
    ];

    protected $casts = [
        'validade' => 'datetime',
        'valor_minimo' => 'float',
        'desconto' => 'float',
    ];

    public function isValido($subtotal)
    {
        if ($this->validade < now()) {
            return false;
        }

        if ($subtotal < $this->valor_minimo) {
            return false;
        }

        return true;
    }

    public function aplicarDesconto($subtotal)
    {
        if (!$this->isValido($subtotal)) {
            return $subtotal;
        }

        return $subtotal - $this->desconto;
    }
}
