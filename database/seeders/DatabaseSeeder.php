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

            // Tạo mục tiêu hàng ngày
            DailyGoal::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'new_words_per_day' => 20,
                    'review_words_per_day' => 50,
                ]
            );

            return $user;
        });

        $users->each(function (User $user) {
            // Tạo 5 bộ từ cho mỗi người dùng
            $sets = VocabularySet::factory()
                ->count(5)
                ->for($user)
                ->create();

            $sets->each(function (VocabularySet $set) use ($user) {
                // Mỗi bộ 40 từ
                $vocabularies = Vocabulary::factory()
                    ->count(40)
                    ->for($set, 'set')
                    ->create();

                $now = now();

                // 1. Tạo tiến độ SRS với phân bố trạng thái đa dạng
                $srsPayload = $vocabularies->map(function (Vocabulary $vocab, int $idx) use ($user, $now) {
                    $status = match (true) {
                        $idx < 5 => 'mastered',
                        $idx < 15 => 'review',
                        $idx < 25 => 'learning',
                        default => 'new',
                    };

                    return [
                        'user_id' => $user->id,
                        'vocabulary_id' => $vocab->id,
                        'status' => $status,
                        'ease_factor' => 2.5,
                        'interval_days' => $status === 'mastered' ? 30 : ($status === 'review' ? 7 : 1),
                        'repetitions' => $status === 'new' ? 0 : 5,
                        'next_review_at' => $status === 'new' ? null : $now->copy()->addDays(rand(1, 10)),
                        'last_reviewed_at' => $status === 'new' ? null : $now->copy()->subDays(rand(1, 5)),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                });
                SrsProgress::insert($srsPayload->all());

                // 2. Tạo lịch sử học tập (Study Logs) trong 7 ngày qua
                $logsPayload = [];
                for ($i = 0; $i < 7; $i++) {
                    $date = $now->copy()->subDays($i);
                    // Mỗi ngày học từ 5-15 từ ngẫu nhiên trong bộ này
                    $dailyVocabs = $vocabularies->random(rand(5, 15));

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

                // Insert thành từng đợt để tránh quá tải
                foreach (array_chunk($logsPayload, 100) as $chunk) {
                    StudyLog::insert($chunk);
                }
            });
        });
    }
}