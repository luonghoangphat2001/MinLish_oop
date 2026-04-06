<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vocabulary;
use App\Models\VocabularySet;
use App\Models\SrsProgress;
use App\Models\StudyLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $usersData = [
            ['name' => 'Pham Nhat Hoang',   'email' => 'phamnhathoang@gmail.com'],
            ['name' => 'To Minh Khoi',      'email' => 'tominhkhoi@gmail.com'],
            ['name' => 'Bui Xuan Nhat Long','email' => 'buixuannhatlong@gmail.com'],
            ['name' => 'Luong Hoang Phat',  'email' => 'luonghoangphat@gmail.com'],
            ['name' => 'Lu Thanh Phuc',     'email' => 'luthanhphuc@gmail.com'],
        ];

        $users = collect($usersData)->map(function (array $data) {
            return User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'   => $data['name'],
                    'password' => Hash::make('123456'),
                    'level'    => 'A1',
                    'goal'     => 'Ôn luyện từ vựng',
                ]
            );
        });

        $users->each(function (User $user) {
            $sets = VocabularySet::factory()
                ->count(2)
                ->for($user)
                ->create();

            $sets->each(function (VocabularySet $set) {
                $vocabularies = Vocabulary::factory()
                    ->count(50)
                    ->for($set, 'set')
                    ->create();

                // Tạo tiến độ SRS cho chủ sở hữu bộ từ
                $now = now();
                $payload = $vocabularies->map(function (Vocabulary $vocab, int $idx) use ($set, $now) {
                    // Phân bố trạng thái để có dữ liệu hiển thị
                    $status = match (true) {
                        $idx < 10  => 'mastered',
                        $idx < 20  => 'review',
                        $idx < 35  => 'learning',
                        default    => 'new',
                    };

                    return [
                        'user_id'        => $set->user_id,
                        'vocabulary_id'  => $vocab->id,
                        'status'         => $status,
                        'ease_factor'    => 2.5,
                        'interval_days'  => 1,
                        'repetitions'    => 0,
                        'next_review_at' => $now->copy()->addDays(1),
                        'last_reviewed_at' => null,
                        'created_at'     => $now,
                        'updated_at'     => $now,
                    ];
                });

                SrsProgress::insert($payload->all());

                // Log một vài lượt học để có dữ liệu "Hôm nay"
                $studyLogs = $vocabularies->take(5)->map(function (Vocabulary $vocab) use ($set, $now) {
                    return [
                        'user_id'       => $set->user_id,
                        'vocabulary_id' => $vocab->id,
                        'rating'        => rand(1, 5),
                        'studied_at'    => $now,
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ];
                });

                StudyLog::insert($studyLogs->all());
            });
        });
    }
}