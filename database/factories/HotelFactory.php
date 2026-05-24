<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Hotel',
            'location' => $this->faker->city() . ', ' . $this->faker->stateAbbr(),
            'room_count' => $this->faker->numberBetween(10, 80),
            'price_per_night' => $this->faker->randomFloat(2, 60, 420),
            'description' => $this->faker->sentence(14),
            'available' => $this->faker->boolean(80),
        ];
    }
}
