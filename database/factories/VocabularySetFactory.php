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
            'name'        => $this->faker->unique()->words(3, true),
            'description' => $this->faker->sentence(8),
            'tags'        => $this->faker->words($this->faker->numberBetween(2, 4)),
            'is_public'   => $this->faker->boolean(20),
        ];
    }
}
