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
        $faker = app(\Faker\Generator::class);
        return [
            'user_id'     => User::factory(),
            'name'        => $faker->unique()->words(3, true),
            'description' => $faker->sentence(8),
            'tags'        => $faker->words($faker->numberBetween(2, 4)),
            'is_public'   => $faker->boolean(20),
        ];
    }
}
