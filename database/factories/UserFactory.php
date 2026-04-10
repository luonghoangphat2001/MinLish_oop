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
        // Fallback if Faker is not installed (Production)
        if (!class_exists('Faker\Factory')) {
            return [
                'name'              => 'Sample User ' . Str::random(5),
                'email'             => 'user_' . Str::random(10) . '@example.com',
                'google_id'         => null,
                'level'             => collect(['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->random(),
                'goal'              => 'Study English daily',
                'streak_days'       => rand(0, 30),
                'last_study_date'   => now()->subDays(rand(0, 30)),
                'email_verified_at' => now(),
                'password'          => static::$password ??= Hash::make('password'),
                'remember_token'    => Str::random(10),
            ];
        }

        $faker = app(\Faker\Generator::class);
        return [
            'name'              => $faker->name(),
            'email'             => $faker->unique()->safeEmail(),
            'google_id'         => null,
            'level'             => $faker->randomElement(['A1', 'A2', 'B1', 'B2', 'C1', 'C2']),
            'goal'              => $faker->randomElement([
                'Hoan thanh 20 tu moi moi ngay',
                'On tap IELTS moi toi',
                'Mo rong tu vung chu de cong viec',
                'Luyen nghe ban tin hang ngay',
            ]),
            'streak_days'       => $faker->numberBetween(0, 30),
            'last_study_date'   => $faker->dateTimeBetween('-30 days', 'now'),
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