<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use phpDocumentor\Reflection\PseudoTypes\False_;

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
    public function definition(): array
    {
        
        return [
            'sku' => $this->faker->unique()->numberBetween(10000, 999999),
            'name' => $this->faker->sentence(),
            'description' => $this->faker->text(200),
            'image_path' => $this->faker->imageUrl(640, 480, 'products', true),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'subcategory_id' => $this->faker->numberBetween(1, 632),
        ];
    }
} 
