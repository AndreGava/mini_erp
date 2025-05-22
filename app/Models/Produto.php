<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'preco',
        'variacoes',
    ];

    protected $casts = [
        'variacoes' => 'array',
        'preco' => 'float',
    ];

    public function estoque()
    {
        return $this->hasMany(Estoque::class);
    }
}
