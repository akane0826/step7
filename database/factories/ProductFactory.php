<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'img_path'=>$this->faker->realText(10),
            'product_name'=>$this->faker->realText(10),
            'maker_name'=>$this->faker->numberBetween($min = 1,$max = 3),
            'price'=>$this->faker->numberBetween($min = 1,$max = 999),
            'stock'=>$this->faker->numberBetween($min = 0,$max = 999),
            'comment'=>$this->faker->realText(20),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
        ];
    }
}
