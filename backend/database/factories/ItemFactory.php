<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence,
            'department_id' => Department::factory(),
        ];
    }
}
