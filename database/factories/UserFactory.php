<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'google_id'         => null,
            'level'             => fake()->randomElement(['A1', 'A2', 'B1', 'B2', 'C1', 'C2']),
            'goal'              => fake()->randomElement([
                'Hoan thanh 20 tu moi moi ngay',
                'On tap IELTS moi toi',
                'Mo rong tu vung chu de cong viec',
                'Luyen nghe ban tin hang ngay',
            ]),
            'streak_days'       => fake()->numberBetween(0, 30),
            'last_study_date'   => fake()->dateTimeBetween('-30 days', 'now'),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}