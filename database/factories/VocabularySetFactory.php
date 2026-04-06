<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VocabularySet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VocabularySet>
 */
class VocabularySetFactory extends Factory
{
    protected $model = VocabularySet::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'name'        => fake()->unique()->words(3, true),
            'description' => fake()->sentence(8),
            'tags'        => fake()->words(fake()->numberBetween(2, 4)),
            'is_public'   => fake()->boolean(20),
        ];
    }
}
