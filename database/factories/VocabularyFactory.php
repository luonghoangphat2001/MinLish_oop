<?php

namespace Database\Factories;

use App\Models\Vocabulary;
use App\Models\VocabularySet;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $word = $picked['word'] ?? $this->faker->word();

        return [
            'set_id' => VocabularySet::factory(),
            'word' => $word,
            'pronunciation' => $picked['pronunciation'],
            'meaning' => $picked['meaning'],
            'description_en' => $picked['description_en'] ?? null,
            'example' => $picked['example'],
            'collocation' => $this->faker->optional()->words(2, true),
            'related_words' => $this->faker->optional()->words(3, true),
            'note' => $picked['note'] ?? null,
        ];
    }
}
