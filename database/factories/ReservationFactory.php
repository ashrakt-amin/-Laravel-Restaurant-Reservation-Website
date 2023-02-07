<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{

    public function definition()
    {
        return [
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'tel_number' => $this->faker->e164PhoneNumber,
            'time' => $this->faker->numberBetween(1, 6),
            'res_date' => \Carbon\Carbon::createFromTimeStamp($this->faker->dateTimeBetween('now', '+20 days')->getTimestamp()),
            'table_id' => $this->faker->numberBetween(1, Table::count()),
            'guest_number' => 1,

        ];
    }
}
