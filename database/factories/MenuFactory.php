<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'description'=>$this->faker->text(),
            'price'=>$this->faker->numberBetween(50,150),
            'category_id'=>$this->faker->numberBetween(1,Category::count())
        ];
    }
}
