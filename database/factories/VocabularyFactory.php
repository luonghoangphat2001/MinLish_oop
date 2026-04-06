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
    protected $model = Vocabulary::class;

    public function definition(): array
    {
        $samples = [
            ['word' => 'apple',      'pronunciation' => '/ˈæp.əl/',        'meaning' => 'quả táo',                 'example' => 'She eats an apple every morning.'],
            ['word' => 'river',      'pronunciation' => '/ˈrɪv.ər/',       'meaning' => 'dòng sông',               'example' => 'The river runs through the city center.'],
            ['word' => 'mountain',   'pronunciation' => '/ˈmaʊn.tən/',     'meaning' => 'ngọn núi',                'example' => 'They climbed a high mountain last summer.'],
            ['word' => 'library',    'pronunciation' => '/ˈlaɪ.brər.i/',   'meaning' => 'thư viện',               'example' => 'I borrowed this book from the library.'],
            ['word' => 'journey',    'pronunciation' => '/ˈdʒɜː.ni/',      'meaning' => 'chuyến đi',               'example' => 'Our journey took three hours by train.'],
            ['word' => 'coffee',     'pronunciation' => '/ˈkɒf.i/',        'meaning' => 'cà phê',                  'example' => 'He drinks black coffee without sugar.'],
            ['word' => 'sunrise',    'pronunciation' => '/ˈsʌn.raɪz/',     'meaning' => 'bình minh',               'example' => 'We watched the sunrise on the beach.'],
            ['word' => 'island',     'pronunciation' => '/ˈaɪ.lənd/',      'meaning' => 'hòn đảo',                 'example' => 'This island is famous for its coral reefs.'],
            ['word' => 'garden',     'pronunciation' => '/ˈɡɑː.dən/',      'meaning' => 'khu vườn',               'example' => 'The roses in the garden are blooming.'],
            ['word' => 'engineer',   'pronunciation' => '/ˌen.dʒɪˈnɪər/',  'meaning' => 'kỹ sư',                  'example' => 'Her father is a software engineer.'],
            ['word' => 'balance',    'pronunciation' => '/ˈbæl.əns/',      'meaning' => 'sự cân bằng',             'example' => 'Work-life balance is important.'],
            ['word' => 'harvest',    'pronunciation' => '/ˈhɑː.vɪst/',     'meaning' => 'mùa thu hoạch',           'example' => 'Farmers celebrate the rice harvest.'],
            ['word' => 'museum',     'pronunciation' => '/mjuːˈziː.əm/',   'meaning' => 'bảo tàng',                'example' => 'The museum closes at 6 p.m.'],
            ['word' => 'festival',   'pronunciation' => '/ˈfes.tɪ.vəl/',   'meaning' => 'lễ hội',                  'example' => 'We joined the lantern festival.'],
            ['word' => 'compass',    'pronunciation' => '/ˈkʌm.pəs/',      'meaning' => 'la bàn',                  'example' => 'The compass helped them find the way.'],
            ['word' => 'notebook',   'pronunciation' => '/ˈnəʊt.bʊk/',     'meaning' => 'sổ tay',                 'example' => 'She writes ideas in a small notebook.'],
            ['word' => 'energy',     'pronunciation' => '/ˈen.ə.dʒi/',     'meaning' => 'năng lượng',              'example' => 'Solar energy is becoming popular.'],
            ['word' => 'patient',    'pronunciation' => '/ˈpeɪ.ʃənt/',     'meaning' => 'bệnh nhân; kiên nhẫn',    'example' => 'The doctor spoke kindly to the patient.'],
            ['word' => 'climate',    'pronunciation' => '/ˈklaɪ.mət/',     'meaning' => 'khí hậu',                 'example' => 'The climate here is mild all year.'],
            ['word' => 'culture',    'pronunciation' => '/ˈkʌl.tʃər/',     'meaning' => 'văn hóa',                 'example' => 'Food is a big part of local culture.'],
        ];

        $picked = $samples[array_rand($samples)];
        $word   = $picked['word'];

        return [
            'set_id'         => VocabularySet::factory(),
            'word'           => $word,
            'pronunciation'  => $picked['pronunciation'],
            'meaning'        => $picked['meaning'],
            'description_en' => fake()->optional()->sentence(10),
            'example'        => $picked['example'],
            'collocation'    => fake()->optional()->words(2, true),
            'related_words'  => fake()->optional()->words(3, true),
            'note'           => fake()->optional()->sentence(8),
        ];
    }
}
