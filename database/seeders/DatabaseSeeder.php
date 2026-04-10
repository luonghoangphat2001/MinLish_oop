<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vocabulary;
use App\Models\VocabularySet;
use App\Models\SrsProgress;
use App\Models\StudyLog;
use App\Models\DailyGoal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $usersData = [
            ['name' => 'Pham Nhat Hoang', 'email' => 'phamnhathoang@gmail.com'],
            ['name' => 'To Minh Khoi', 'email' => 'tominhkhoi@gmail.com'],
            ['name' => 'Bui Xuan Nhat Long', 'email' => 'buixuannhatlong@gmail.com'],
            ['name' => 'Luong Hoang Phat', 'email' => 'luonghoangphat@gmail.com'],
            ['name' => 'Lu Thanh Phuc', 'email' => 'luthanhphuc@gmail.com'],
        ];

        $users = collect($usersData)->map(function (array $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('123456'),
                    'level' => 'A1',
                    'goal' => 'Ôn luyện từ vựng',
                ]
            );

            DailyGoal::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'new_words_per_day' => 20,
                    'review_words_per_day' => 50,
                ]
            );

            return $user;
        });

        // Get all topic files
        $topicFiles = glob(base_path('data/topics/*.json'));
        $firstUser = $users->first();

        foreach ($topicFiles as $file) {
            $topicName = ucfirst(basename($file, '.json'));
            $data = json_decode(file_get_contents($file), true);

            // Create a public vocabulary set for each topic
            $set = VocabularySet::create([
                'user_id' => $firstUser->id,
                'name' => $topicName,
                'description' => "Bộ từ vựng chủ đề $topicName với 50 từ chuyên sâu.",
                'is_public' => true,
                'tags' => [$topicName, 'Official'],
            ]);

            $vocabularies = collect($data)->map(function ($wordData) use ($set) {
                return Vocabulary::create([
                    'set_id' => $set->id,
                    'word' => $wordData['word'],
                    'pronunciation' => $wordData['pronunciation'],
                    'meaning' => $wordData['meaning'],
                    'description_en' => $wordData['description_en'] ?? null,
                    'example' => $wordData['example'],
                    'note' => $wordData['note'] ?? null,
                    'collocation' => null,
                    'related_words' => null,
                ]);
            });

            // For each user, create some simulated progress for this set
            $users->each(function (User $user) use ($vocabularies) {
                $now = now();

                // Select 30 random words from this set to have progress for this user
                $selectedVocabs = $vocabularies->random(30);

                $srsPayload = $selectedVocabs->map(function (Vocabulary $vocab, int $idx) use ($user, $now) {
                    $status = match (true) {
                        $idx < 5 => 'mastered',
                        $idx < 15 => 'review',
                        default => 'learning',
                    };

                    return [
                        'user_id' => $user->id,
                        'vocabulary_id' => $vocab->id,
                        'status' => $status,
                        'ease_factor' => 2.5,
                        'interval_days' => $status === 'mastered' ? 30 : ($status === 'review' ? 7 : 1),
                        'repetitions' => $status === 'learning' ? 1 : 5,
                        'next_review_at' => $status === 'learning' ? $now->copy()->addDay() : $now->copy()->addDays(rand(1, 15)),
                        'last_reviewed_at' => $now->copy()->subDays(rand(1, 5)),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                });

                SrsProgress::insert($srsPayload->all());

                // 2. Tạo lịch sử học tập (Study Logs) trong 7 ngày qua
                $logsPayload = [];
                for ($i = 0; $i < 7; $i++) {
                    $date = $now->copy()->subDays($i);
                    $dailyVocabs = $selectedVocabs->random(rand(2, 5));

                    foreach ($dailyVocabs as $vocab) {
                        $logsPayload[] = [
                            'user_id' => $user->id,
                            'vocabulary_id' => $vocab->id,
                            'rating' => collect(['again', 'hard', 'good', 'easy'])->random(),
                            'studied_at' => $date,
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];
                    }
                }

                foreach (array_chunk($logsPayload, 100) as $chunk) {
                    StudyLog::insert($chunk);
                }
            });
        }
    }
}