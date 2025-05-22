<?php

namespace Database\Factories;

use App\Models\Cupom;
use Illuminate\Database\Eloquent\Factories\Factory;

class CupomFactory extends Factory
{
    protected $model = Cupom::class;

    public function definition()
    {
        return [
            'codigo' => strtoupper($this->faker->unique()->lexify('??????')),
            'validade' => $this->faker->dateTimeBetween('now', '+1 year'),
            'valor_minimo' => $this->faker->randomFloat(2, 10, 100),
            'desconto' => $this->faker->randomFloat(2, 5, 50),
        ];
    }
}
