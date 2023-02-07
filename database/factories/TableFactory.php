<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    public function definition()
    {
        return [
            'name'=>$this->faker->name , 
            'guest_number'=>$this->faker->numberBetween(1,20), 
            'status'=>$this->faker->randomElement(['Pending', 'Available','Unavailable']),
            'location'=>$this->faker->randomElement(['Front', 'Inside','Outside']),
        ];
    }
}
