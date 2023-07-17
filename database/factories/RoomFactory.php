<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(2),
            'description'=> $this->faker->sentence(15),
            'poster_url'=> $this->faker->imageUrl(800, 600, 'room'),
            'floor_area'=>$this->faker->numberBetween(50, 300),
            'type'=>$this->faker->randomElement(['low coast', 'middle', 'premium', 'buisness']),
            'price'=>$this->faker->numberBetween(5000, 100000),
        ];
    }
}
