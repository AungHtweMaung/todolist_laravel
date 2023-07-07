<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $address = ["Mandalay", "Yangon", "Pyin Oo Lwin", "Taung Gyi", "Inn Lay"];
        $address_key = array_rand($address);

        return [
            "title" => $this->faker->sentence(6),
            "description" => $this->faker->text(200),
            "address" => $address[$address_key],
            "price" => rand(2000, 50000),
            "rating" => rand(0, 5),
        ];
    }
}
