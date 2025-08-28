<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;

        return [
            'module_id' => Module::factory(),
            'name' => $name,
            'description' => $this->faker->sentence(20),
            'video' => $this->faker->url,
            'url' => Str::slug($name)
        ];
    }
}
