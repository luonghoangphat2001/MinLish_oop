<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vocabulary;
use App\Models\VocabularySet;

class StarterVocabularyService
{

    public function seedDefaultForUser(User $user): void
    {
        if ($user->vocabularySets()->exists()) {
            return;
        }

        foreach ($this->defaultSets() as $setData) {
            $set = VocabularySet::create([
                'user_id' => $user->id,
                'name' => $setData['name'],
                'description' => $setData['description'],
                'tags' => $setData['tags'],
                'is_public' => false,
            ]);

            $rows = [];
            foreach ($setData['words'] as $word) {
                $rows[] = [
                    'set_id' => $set->id,
                    'word' => $word['word'],
                    'meaning' => $word['meaning'],
                    'pronunciation' => $word['pronunciation'] ?? null,
                    'example' => $word['example'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Vocabulary::insert($rows);
        }
    }

    private function defaultSets(): array
    {
        return [
            [
                'name' => 'Learning',
                'description' => 'Bộ mặc định: từ vựng về học tập.',
                'tags' => ['learning', 'study', 'default'],
                'words' => [
                    ['word' => 'analyze', 'meaning' => 'phân tích', 'pronunciation' => '/an-uh-lize/', 'example' => 'Students analyze the data carefully.'],
                    ['word' => 'concept', 'meaning' => 'khái niệm', 'pronunciation' => '/kon-sept/', 'example' => 'This concept is easy to understand.'],
                    ['word' => 'memorize', 'meaning' => 'ghi nhớ', 'pronunciation' => '/mem-uh-rise/', 'example' => 'I memorize ten new words every day.'],
                    ['word' => 'practice', 'meaning' => 'luyện tập', 'pronunciation' => '/prak-tis/', 'example' => 'Practice makes your speaking better.'],
                    ['word' => 'assignment', 'meaning' => 'bài tập được giao', 'pronunciation' => '/uh-sign-ment/', 'example' => 'I submitted my assignment on time.'],
                    ['word' => 'research', 'meaning' => 'nghiên cứu', 'pronunciation' => '/ree-surch/', 'example' => 'She is doing research for her project.'],
                ],
            ],
            [
                'name' => 'Working',
                'description' => 'Bộ mặc định: từ vựng về công việc công sở.',
                'tags' => ['working', 'business', 'default'],
                'words' => [
                    ['word' => 'deadline', 'meaning' => 'hạn chót', 'pronunciation' => '/dead-line/', 'example' => 'The deadline is next Friday.'],
                    ['word' => 'meeting', 'meaning' => 'cuộc họp', 'pronunciation' => '/mee-ting/', 'example' => 'We have a meeting at 9 AM.'],
                    ['word' => 'colleague', 'meaning' => 'đồng nghiệp', 'pronunciation' => '/kol-leeg/', 'example' => 'My colleague helped me finish the task.'],
                    ['word' => 'proposal', 'meaning' => 'đề xuất', 'pronunciation' => '/pro-po-zal/', 'example' => 'The client approved our proposal.'],
                    ['word' => 'schedule', 'meaning' => 'lịch trình', 'pronunciation' => '/ske-jool/', 'example' => 'Please check your work schedule.'],
                    ['word' => 'collaborate', 'meaning' => 'hợp tác', 'pronunciation' => '/kuh-lab-uh-rate/', 'example' => 'Teams collaborate to solve problems quickly.'],
                ],
            ],
        ];
    }
}
