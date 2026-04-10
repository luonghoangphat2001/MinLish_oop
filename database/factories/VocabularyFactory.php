<?php

namespace Database\Factories;

use App\Models\Vocabulary;
use App\Models\VocabularySet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Vocabulary>
 */
class VocabularyFactory extends Factory
{
    protected static $samples = null;

    public function definition(): array
    {
        if (is_null(self::$samples)) {
            $json = file_get_contents(base_path('data/vocabulary.json'));
            self::$samples = json_decode($json, true);
        }

        $picked = self::$samples[array_rand(self::$samples)];
        $word = $picked['word'] ?? 'sample';

        // Fallback if Faker is not installed (Production)
        if (!class_exists('Faker\Factory')) {
            return [
                'set_id' => VocabularySet::factory(),
                'word' => $word,
                'pronunciation' => $picked['pronunciation'] ?? '',
                'meaning' => $picked['meaning'] ?? '',
                'description_en' => $picked['description_en'] ?? null,
                'example' => $picked['example'] ?? '',
                'collocation' => 'sample collocation',
                'related_words' => 'related, words',
                'note' => $picked['note'] ?? null,
            ];
        }

        $faker = app(\Faker\Generator::class);
        return [
            'set_id' => VocabularySet::factory(),
            'word' => $word,
            'pronunciation' => $picked['pronunciation'],
            'meaning' => $picked['meaning'],
            'description_en' => $picked['description_en'] ?? null,
            'example' => $picked['example'],
            'collocation' => $faker->optional()->words(2, true),
            'related_words' => $faker->optional()->words(3, true),
            'note' => $picked['note'] ?? null,
        ];
    }
}
