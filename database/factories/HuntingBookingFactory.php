<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HuntingBooking>
 */
class HuntingBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tour_name' => $this->faker->words(3, true),
            'hunter_name' => $this->faker->name(),
            'guide_id' => Guide::factory(),
            'date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
            'participants_count' => rand(1, 10),
        ];
    }
}
