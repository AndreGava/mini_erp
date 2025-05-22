<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    protected $table = 'estoques';

    protected $fillable = [
        'produto_id',
        'quantidade',
        'variacao',
    ];

    protected $casts = [
        'variacao' => 'array',
        'quantidade' => 'integer',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
