# MinLish - Ứng Dụng Học Từ Vựng Tiếng Anh - Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Xây dựng ứng dụng web học từ vựng tiếng Anh MinLish dùng Laravel + Livewire + Tailwind CSS, hỗ trợ Flashcard, SRS (SM-2), và theo dõi tiến độ học cho 10k user đồng thời.

**Architecture:** Monolith Laravel với TALL Stack (Tailwind + AlpineJS + Livewire + Laravel). Backend xử lý SRS logic và Queue cho notifications. Frontend dùng Livewire components (không cần API riêng). Mỗi module là một folder trong `app/` theo chuẩn OOP rõ ràng.

**Tech Stack:** PHP 8.2+, Laravel 11, Livewire 3, Tailwind CSS 3, AlpineJS 3, MySQL 8, Laravel Breeze (auth), Maatwebsite/Excel (import/export), Laravel Queue (notifications), Laravel Sanctum.

---

## Phân Chia Team (4 Dev + 1 QC / 5 Ngày)

| Dev | Ngày 1 | Ngày 2 | Ngày 3 | Ngày 4 | Ngày 5 |
|-----|--------|--------|--------|--------|--------|
| **Dev 1** | Setup Project + DB Migrations | User Auth + Profile | SRS Algorithm (SM-2) | Daily Plan + Schedule | Bug fix + Deploy |
| **Dev 2** | Vocabulary Model + CRUD | Vocab Set Management | Import/Export Excel | Flashcard Component | Bug fix + Polish |
| **Dev 3** | UI Layout + Livewire Setup | Flashcard UI | Learning Session | Progress Dashboard | Responsive + CSS |
| **Dev 4** | Notification System skeleton | Queue + Email | Push Notification | Analytics Charts | Bug fix + QC support |
| **QC** | Review spec + Test plan | Test Day 1 output | Test Day 2 output | Test Day 3 output | Final E2E Test |

---

## Database Schema

```sql
-- users
id, name, email, password, google_id, level (ENUM: A1-C2), goal (IELTS/giao_tiep/business), 
streak_days, last_study_date, created_at, updated_at

-- vocabulary_sets
id, user_id, name, description, tags (JSON), is_public, created_at, updated_at

-- vocabularies
id, set_id, word, pronunciation, meaning, description_en, example, 
collocation, related_words, note, created_at, updated_at

-- srs_progress (1 row per user per vocabulary)
id, user_id, vocabulary_id, ease_factor (default 2.5), interval_days (default 1), 
repetitions (default 0), next_review_at, last_reviewed_at, 
status (ENUM: new/learning/review/mastered)

-- study_logs
id, user_id, vocabulary_id, rating (ENUM: again/hard/good/easy), 
studied_at, created_at

-- daily_goals
id, user_id, new_words_per_day (default 10), review_words_per_day (default 20)
```

---

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── (chỉ dùng cho non-Livewire routes)
│   └── Livewire/
│       ├── Auth/
│       │   └── ProfileEdit.php
│       ├── Vocabulary/
│       │   ├── VocabularySetIndex.php    # Danh sách bộ từ
│       │   ├── VocabularySetForm.php     # Tạo/sửa bộ từ
│       │   ├── VocabularyIndex.php       # Danh sách từ trong bộ
│       │   └── VocabularyForm.php        # Thêm/sửa từ
│       ├── Learning/
│       │   ├── FlashCard.php             # Component học flashcard
│       │   ├── DailyPlan.php             # Kế hoạch học hôm nay
│       │   └── LearningSession.php       # Phiên học (SM-2 engine)
│       └── Dashboard/
│           ├── ProgressDashboard.php     # Tổng quan tiến độ
│           └── ActivityChart.php         # Biểu đồ hoạt động
├── Models/
│   ├── User.php
│   ├── VocabularySet.php
│   ├── Vocabulary.php
│   ├── SrsProgress.php
│   ├── StudyLog.php
│   └── DailyGoal.php
├── Services/
│   └── SpacedRepetitionService.php       # SM-2 algorithm logic
├── Jobs/
│   ├── SendDailyReminderJob.php
│   └── SendReviewReminderJob.php
└── Notifications/
    ├── DailyStudyReminder.php
    └── ReviewWordsReminder.php

resources/views/
├── layouts/
│   ├── app.blade.php                     # Layout chính sau login
│   └── guest.blade.php                   # Layout login/register
├── livewire/
│   ├── auth/profile-edit.blade.php
│   ├── vocabulary/
│   │   ├── set-index.blade.php
│   │   ├── set-form.blade.php
│   │   ├── vocabulary-index.blade.php
│   │   └── vocabulary-form.blade.php
│   ├── learning/
│   │   ├── flash-card.blade.php
│   │   ├── daily-plan.blade.php
│   │   └── learning-session.blade.php
│   └── dashboard/
│       ├── progress-dashboard.blade.php
│       └── activity-chart.blade.php
└── pages/
    ├── dashboard.blade.php
    ├── vocabulary/
    │   ├── sets.blade.php
    │   └── words.blade.php
    └── learning/
        ├── today.blade.php
        └── flashcard.blade.php
```

---

## Task 1: Setup Project & Kết Nối GitHub (Dev 1 - Ngày 1, ~2h)

**Files:**
- Create: `composer.json`, `package.json`, `.env.example`
- Create: `database/migrations/` (tất cả migration files)
- Modify: `routes/web.php`

### 1.1 Khởi tạo Laravel project

- [ ] **Step 1: Tạo Laravel project mới**

```bash
cd /Users/luonghoangphat/Documents/CNKT/MinLish_oop
composer create-project laravel/laravel . --prefer-dist
```

- [ ] **Step 2: Install Laravel Breeze (Auth)**

```bash
composer require laravel/breeze --dev
php artisan breeze:install livewire
npm install && npm run build
```

- [ ] **Step 3: Cài thêm packages**

```bash
composer require maatwebsite/excel
composer require livewire/livewire
npm install -D tailwindcss @tailwindcss/forms @tailwindcss/typography
```

- [ ] **Step 4: Kết nối GitHub**

```bash
git init
git remote add origin https://github.com/luonghoangphat2001/MinLish_oop.git
git add .
git commit -m "feat: initial Laravel project setup with Breeze + Livewire"
git push -u origin main
```

### 1.2 Tạo tất cả Database Migrations

- [ ] **Step 5: Tạo migrations**

```bash
php artisan make:migration add_profile_fields_to_users_table
php artisan make:migration create_vocabulary_sets_table
php artisan make:migration create_vocabularies_table
php artisan make:migration create_srs_progress_table
php artisan make:migration create_study_logs_table
php artisan make:migration create_daily_goals_table
```

- [ ] **Step 6: Viết migration add_profile_fields_to_users_table**

File: `database/migrations/xxxx_add_profile_fields_to_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('email');
            $table->enum('level', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->default('A1')->after('google_id');
            $table->string('goal')->nullable()->after('level'); // IELTS, giao_tiep, business
            $table->integer('streak_days')->default(0)->after('goal');
            $table->date('last_study_date')->nullable()->after('streak_days');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'level', 'goal', 'streak_days', 'last_study_date']);
        });
    }
};
```

- [ ] **Step 7: Viết migration create_vocabulary_sets_table**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vocabulary_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('tags')->nullable(); // ['IELTS', 'Business', 'Travel']
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocabulary_sets');
    }
};
```

- [ ] **Step 8: Viết migration create_vocabularies_table**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_id')->constrained('vocabulary_sets')->cascadeOnDelete();
            $table->string('word');
            $table->string('pronunciation')->nullable();
            $table->text('meaning');
            $table->text('description_en')->nullable();
            $table->text('example')->nullable();
            $table->text('collocation')->nullable();
            $table->text('related_words')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocabularies');
    }
};
```

- [ ] **Step 9: Viết migration create_srs_progress_table**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('srs_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->cascadeOnDelete();
            $table->float('ease_factor')->default(2.5);  // SM-2: EF
            $table->integer('interval_days')->default(1); // SM-2: I
            $table->integer('repetitions')->default(0);   // SM-2: n
            $table->timestamp('next_review_at')->nullable();
            $table->timestamp('last_reviewed_at')->nullable();
            $table->enum('status', ['new', 'learning', 'review', 'mastered'])->default('new');
            $table->unique(['user_id', 'vocabulary_id']); // 1 user chỉ có 1 progress per word
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('srs_progress');
    }
};
```

- [ ] **Step 10: Viết migration create_study_logs_table**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->cascadeOnDelete();
            $table->enum('rating', ['again', 'hard', 'good', 'easy']);
            $table->timestamp('studied_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_logs');
    }
};
```

- [ ] **Step 11: Viết migration create_daily_goals_table**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();
            $table->integer('new_words_per_day')->default(10);
            $table->integer('review_words_per_day')->default(20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_goals');
    }
};
```

- [ ] **Step 12: Chạy migrations**

```bash
php artisan migrate
```
Expected: All migrations ran successfully.

- [ ] **Step 13: Commit**

```bash
git add database/migrations/
git commit -m "feat: add all database migrations for MinLish schema"
git push
```

---

## Task 2: Models (Dev 1 - Ngày 1, ~1h)

**Files:**
- Modify: `app/Models/User.php`
- Create: `app/Models/VocabularySet.php`
- Create: `app/Models/Vocabulary.php`
- Create: `app/Models/SrsProgress.php`
- Create: `app/Models/StudyLog.php`
- Create: `app/Models/DailyGoal.php`

- [ ] **Step 1: Cập nhật User Model**

```bash
php artisan make:model VocabularySet
php artisan make:model Vocabulary
php artisan make:model SrsProgress
php artisan make:model StudyLog
php artisan make:model DailyGoal
```

- [ ] **Step 2: Viết `app/Models/User.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'google_id',
        'level', 'goal', 'streak_days', 'last_study_date',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_study_date'   => 'date',
        'password'          => 'hashed',
    ];

    // Relationships
    public function vocabularySets()
    {
        return $this->hasMany(VocabularySet::class);
    }

    public function srsProgresses()
    {
        return $this->hasMany(SrsProgress::class);
    }

    public function studyLogs()
    {
        return $this->hasMany(StudyLog::class);
    }

    public function dailyGoal()
    {
        return $this->hasOne(DailyGoal::class);
    }

    // Helper: tổng số từ đã học
    public function getTotalLearnedWordsAttribute(): int
    {
        return $this->srsProgresses()
            ->whereIn('status', ['review', 'mastered'])
            ->count();
    }
}
```

- [ ] **Step 3: Viết `app/Models/VocabularySet.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VocabularySet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'tags', 'is_public'];

    protected $casts = [
        'tags'      => 'array',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class, 'set_id');
    }

    public function getWordCountAttribute(): int
    {
        return $this->vocabularies()->count();
    }
}
```

- [ ] **Step 4: Viết `app/Models/Vocabulary.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'set_id', 'word', 'pronunciation', 'meaning',
        'description_en', 'example', 'collocation', 'related_words', 'note',
    ];

    public function set()
    {
        return $this->belongsTo(VocabularySet::class, 'set_id');
    }

    public function srsProgress()
    {
        return $this->hasMany(SrsProgress::class);
    }

    public function userProgress(int $userId)
    {
        return $this->srsProgress()->where('user_id', $userId)->first();
    }
}
```

- [ ] **Step 5: Viết `app/Models/SrsProgress.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SrsProgress extends Model
{
    use HasFactory;

    protected $table = 'srs_progress';

    protected $fillable = [
        'user_id', 'vocabulary_id', 'ease_factor', 'interval_days',
        'repetitions', 'next_review_at', 'last_reviewed_at', 'status',
    ];

    protected $casts = [
        'next_review_at'    => 'datetime',
        'last_reviewed_at'  => 'datetime',
        'ease_factor'       => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }

    public function isDueForReview(): bool
    {
        return $this->next_review_at === null || $this->next_review_at->isPast();
    }
}
```

- [ ] **Step 6: Viết `app/Models/StudyLog.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'vocabulary_id', 'rating', 'studied_at'];

    protected $casts = [
        'studied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }
}
```

- [ ] **Step 7: Commit**

```bash
git add app/Models/
git commit -m "feat: add all Eloquent models with relationships"
git push
```

---

## Task 3: Thuật Toán SM-2 - SpacedRepetitionService (Dev 1 - Ngày 3, ~2h)

**Files:**
- Create: `app/Services/SpacedRepetitionService.php`
- Test: `tests/Unit/SpacedRepetitionServiceTest.php`

### Giải thích SM-2:
```
Rating: again=0, hard=1, good=3, easy=5  (map sang q)
Nếu q < 3: reset lại (repetitions=0, interval=1)
Nếu q >= 3:
  - n=0: I(1) = 1 ngày
  - n=1: I(2) = 6 ngày
  - n>1: I(n+1) = I(n) * EF
  EF = EF + (0.1 - (5-q) * (0.08 + (5-q) * 0.02))
  EF tối thiểu = 1.3
```

- [ ] **Step 1: Viết failing test trước**

File: `tests/Unit/SpacedRepetitionServiceTest.php`

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\SpacedRepetitionService;

class SpacedRepetitionServiceTest extends TestCase
{
    private SpacedRepetitionService $srs;

    protected function setUp(): void
    {
        parent::setUp();
        $this->srs = new SpacedRepetitionService();
    }

    /** @test */
    public function it_resets_when_rating_is_again()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 10, repetitions: 5, rating: 'again');

        $this->assertEquals(0, $result['repetitions']);
        $this->assertEquals(1, $result['interval_days']);
        $this->assertEquals('learning', $result['status']);
    }

    /** @test */
    public function it_sets_interval_to_1_on_first_good_review()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 1, repetitions: 0, rating: 'good');

        $this->assertEquals(1, $result['repetitions']);
        $this->assertEquals(1, $result['interval_days']);
    }

    /** @test */
    public function it_sets_interval_to_6_on_second_good_review()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 1, repetitions: 1, rating: 'good');

        $this->assertEquals(2, $result['repetitions']);
        $this->assertEquals(6, $result['interval_days']);
    }

    /** @test */
    public function it_increases_interval_using_ease_factor_for_subsequent_reviews()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 6, repetitions: 2, rating: 'good');

        $this->assertEquals(3, $result['repetitions']);
        $this->assertEquals(15, $result['interval_days']); // round(6 * 2.5) = 15
    }

    /** @test */
    public function ease_factor_never_goes_below_1_3()
    {
        $result = $this->srs->calculate(easeFactor: 1.3, intervalDays: 1, repetitions: 1, rating: 'hard');

        $this->assertGreaterThanOrEqual(1.3, $result['ease_factor']);
    }

    /** @test */
    public function it_marks_word_as_mastered_after_long_interval()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 21, repetitions: 5, rating: 'easy');

        $this->assertEquals('mastered', $result['status']);
    }
}
```

- [ ] **Step 2: Chạy test để xem fail**

```bash
php artisan test tests/Unit/SpacedRepetitionServiceTest.php
```
Expected: FAIL - class not found.

- [ ] **Step 3: Implement `app/Services/SpacedRepetitionService.php`**

```php
<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * SpacedRepetitionService
 *
 * Áp dụng thuật toán SM-2 để tính lịch ôn từ vựng.
 * 
 * Cách dùng:
 *   $srs = new SpacedRepetitionService();
 *   $result = $srs->calculate($easeFactor, $intervalDays, $repetitions, 'good');
 *   // $result = ['ease_factor', 'interval_days', 'repetitions', 'next_review_at', 'status']
 */
class SpacedRepetitionService
{
    // Map rating string sang SM-2 quality score (0-5)
    private const RATING_TO_QUALITY = [
        'again' => 0,
        'hard'  => 1,
        'good'  => 3,
        'easy'  => 5,
    ];

    // Nếu học >= 21 ngày liên tục, coi là "mastered"
    private const MASTERED_INTERVAL_THRESHOLD = 21;

    /**
     * Tính toán thông số SRS mới sau khi user đánh giá một từ.
     *
     * @param float  $easeFactor   Hệ số dễ hiện tại (mặc định 2.5)
     * @param int    $intervalDays Khoảng cách ôn hiện tại (ngày)
     * @param int    $repetitions  Số lần đã ôn thành công liên tiếp
     * @param string $rating       Đánh giá: again | hard | good | easy
     * @return array
     */
    public function calculate(float $easeFactor, int $intervalDays, int $repetitions, string $rating): array
    {
        $quality = self::RATING_TO_QUALITY[$rating] ?? 3;

        if ($quality < 3) {
            // User quên - reset về đầu
            return $this->buildResult(
                easeFactor: max(1.3, $easeFactor - 0.2),
                intervalDays: 1,
                repetitions: 0,
                status: 'learning'
            );
        }

        // Tính interval mới theo SM-2
        $newInterval = match ($repetitions) {
            0 => 1,
            1 => 6,
            default => (int) round($intervalDays * $easeFactor),
        };

        // Cập nhật ease factor
        $newEaseFactor = $easeFactor + (0.1 - (5 - $quality) * (0.08 + (5 - $quality) * 0.02));
        $newEaseFactor = max(1.3, $newEaseFactor);

        $newRepetitions = $repetitions + 1;
        $status = $newInterval >= self::MASTERED_INTERVAL_THRESHOLD ? 'mastered' : 'review';

        return $this->buildResult($newEaseFactor, $newInterval, $newRepetitions, $status);
    }

    /**
     * Build kết quả trả về với next_review_at đã tính.
     */
    private function buildResult(float $easeFactor, int $intervalDays, int $repetitions, string $status): array
    {
        return [
            'ease_factor'    => round($easeFactor, 4),
            'interval_days'  => $intervalDays,
            'repetitions'    => $repetitions,
            'next_review_at' => Carbon::now()->addDays($intervalDays),
            'status'         => $status,
        ];
    }
}
```

- [ ] **Step 4: Chạy test để xem pass**

```bash
php artisan test tests/Unit/SpacedRepetitionServiceTest.php
```
Expected: 6 tests passed.

- [ ] **Step 5: Commit**

```bash
git add app/Services/SpacedRepetitionService.php tests/Unit/SpacedRepetitionServiceTest.php
git commit -m "feat: implement SM-2 spaced repetition algorithm with unit tests"
git push
```

---

## Task 4: User Auth & Profile (Dev 2 - Ngày 2, ~2h)

**Files:**
- Create: `app/Http/Livewire/Auth/ProfileEdit.php`
- Create: `resources/views/livewire/auth/profile-edit.blade.php`

> **Note:** Breeze đã tạo sẵn login/register. Task này chỉ cần thêm Profile fields.

- [ ] **Step 1: Tạo Livewire component**

```bash
php artisan make:livewire Auth/ProfileEdit
```

- [ ] **Step 2: Viết `app/Http/Livewire/Auth/ProfileEdit.php`**

```php
<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileEdit extends Component
{
    public string $name    = '';
    public string $level   = 'A1';
    public string $goal    = '';
    public int $new_words  = 10;
    public int $review_words = 20;

    // Validation rules
    protected array $rules = [
        'name'          => 'required|string|max:255',
        'level'         => 'required|in:A1,A2,B1,B2,C1,C2',
        'goal'          => 'nullable|string|max:100',
        'new_words'     => 'required|integer|min:1|max:100',
        'review_words'  => 'required|integer|min:1|max:200',
    ];

    public function mount(): void
    {
        $user = Auth::user();
        $this->name  = $user->name;
        $this->level = $user->level ?? 'A1';
        $this->goal  = $user->goal ?? '';

        $goal = $user->dailyGoal;
        if ($goal) {
            $this->new_words     = $goal->new_words_per_day;
            $this->review_words  = $goal->review_words_per_day;
        }
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();
        $user->update([
            'name'  => $this->name,
            'level' => $this->level,
            'goal'  => $this->goal,
        ]);

        // Upsert DailyGoal (tạo mới nếu chưa có)
        $user->dailyGoal()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'new_words_per_day'    => $this->new_words,
                'review_words_per_day' => $this->review_words,
            ]
        );

        session()->flash('message', 'Đã lưu hồ sơ thành công!');
    }

    public function render()
    {
        return view('livewire.auth.profile-edit');
    }
}
```

- [ ] **Step 3: Viết view `resources/views/livewire/auth/profile-edit.blade.php`**

```blade
<div class="max-w-xl mx-auto py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Hồ sơ của tôi</h2>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-5 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        {{-- Tên --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
            <input wire:model.defer="name" type="text"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                placeholder="Nguyen Van A">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Level --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Trình độ hiện tại</label>
            <select wire:model.defer="level"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @foreach (['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $lvl)
                    <option value="{{ $lvl }}">{{ $lvl }}</option>
                @endforeach
            </select>
        </div>

        {{-- Mục tiêu --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mục tiêu học</label>
            <input wire:model.defer="goal" type="text"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                placeholder="IELTS, Giao tiếp, Business...">
        </div>

        {{-- Daily Goal --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Từ mới / ngày</label>
                <input wire:model.defer="new_words" type="number" min="1" max="100"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('new_words') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Từ ôn / ngày</label>
                <input wire:model.defer="review_words" type="number" min="1" max="200"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-200 cursor-pointer">
            Lưu hồ sơ
        </button>
    </form>
</div>
```

- [ ] **Step 4: Thêm route vào `routes/web.php`**

```php
use App\Http\Livewire\Auth\ProfileEdit;

Route::middleware('auth')->group(function () {
    Route::get('/profile', ProfileEdit::class)->name('profile');
    // ... các routes khác sẽ thêm vào đây
});
```

- [ ] **Step 5: Commit**

```bash
git add app/Http/Livewire/Auth/ resources/views/livewire/auth/ routes/web.php
git commit -m "feat: add profile edit page with daily goal settings"
git push
```

---

## Task 5: Vocabulary Set & Vocabulary CRUD (Dev 2 - Ngày 3-4, ~4h)

**Files:**
- Create: `app/Http/Livewire/Vocabulary/VocabularySetIndex.php`
- Create: `app/Http/Livewire/Vocabulary/VocabularySetForm.php`
- Create: `app/Http/Livewire/Vocabulary/VocabularyIndex.php`
- Create: `app/Http/Livewire/Vocabulary/VocabularyForm.php`
- Create: `resources/views/livewire/vocabulary/` (tất cả views)

- [ ] **Step 1: Tạo Livewire components**

```bash
php artisan make:livewire Vocabulary/VocabularySetIndex
php artisan make:livewire Vocabulary/VocabularySetForm
php artisan make:livewire Vocabulary/VocabularyIndex
php artisan make:livewire Vocabulary/VocabularyForm
```

- [ ] **Step 2: Viết `app/Http/Livewire/Vocabulary/VocabularySetIndex.php`**

```php
<?php

namespace App\Http\Livewire\Vocabulary;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\VocabularySet;

class VocabularySetIndex extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteSet(int $setId): void
    {
        $set = VocabularySet::where('user_id', Auth::id())->findOrFail($setId);
        $set->delete();

        session()->flash('message', 'Đã xoá bộ từ!');
    }

    public function render()
    {
        $sets = VocabularySet::where('user_id', Auth::id())
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->withCount('vocabularies')
            ->latest()
            ->paginate(12);

        return view('livewire.vocabulary.set-index', compact('sets'));
    }
}
```

- [ ] **Step 3: Viết `app/Http/Livewire/Vocabulary/VocabularySetForm.php`**

```php
<?php

namespace App\Http\Livewire\Vocabulary;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\VocabularySet;

class VocabularySetForm extends Component
{
    public ?int $setId = null;
    public string $name        = '';
    public string $description = '';
    public string $tagsInput   = ''; // Nhập tags dạng "IELTS, Business"
    public bool $is_public     = false;

    protected array $rules = [
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'tagsInput'   => 'nullable|string',
        'is_public'   => 'boolean',
    ];

    public function mount(?int $setId = null): void
    {
        if ($setId) {
            $set = VocabularySet::where('user_id', Auth::id())->findOrFail($setId);
            $this->setId      = $set->id;
            $this->name        = $set->name;
            $this->description = $set->description ?? '';
            $this->tagsInput   = implode(', ', $set->tags ?? []);
            $this->is_public   = $set->is_public;
        }
    }

    public function save(): void
    {
        $this->validate();

        // Parse tags từ string "IELTS, Business" thành array
        $tags = array_filter(array_map('trim', explode(',', $this->tagsInput)));

        $data = [
            'user_id'     => Auth::id(),
            'name'        => $this->name,
            'description' => $this->description,
            'tags'        => array_values($tags),
            'is_public'   => $this->is_public,
        ];

        if ($this->setId) {
            VocabularySet::where('user_id', Auth::id())->findOrFail($this->setId)->update($data);
        } else {
            VocabularySet::create($data);
        }

        return redirect()->route('vocabulary.sets')->with('message', 'Đã lưu bộ từ!');
    }

    public function render()
    {
        return view('livewire.vocabulary.set-form');
    }
}
```

- [ ] **Step 4: Viết `app/Http/Livewire/Vocabulary/VocabularyForm.php`**

```php
<?php

namespace App\Http\Livewire\Vocabulary;

use Livewire\Component;
use App\Models\VocabularySet;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;

class VocabularyForm extends Component
{
    public int $setId;
    public ?int $vocabId = null;

    public string $word          = '';
    public string $pronunciation = '';
    public string $meaning       = '';
    public string $description_en = '';
    public string $example       = '';
    public string $collocation   = '';
    public string $related_words = '';
    public string $note          = '';

    protected array $rules = [
        'word'          => 'required|string|max:255',
        'pronunciation' => 'nullable|string|max:255',
        'meaning'       => 'required|string|max:1000',
        'description_en' => 'nullable|string',
        'example'       => 'nullable|string',
        'collocation'   => 'nullable|string',
        'related_words' => 'nullable|string',
        'note'          => 'nullable|string',
    ];

    public function mount(int $setId, ?int $vocabId = null): void
    {
        // Đảm bảo user chỉ edit được từ trong set của mình
        VocabularySet::where('user_id', Auth::id())->findOrFail($setId);
        $this->setId = $setId;

        if ($vocabId) {
            $vocab = Vocabulary::where('set_id', $setId)->findOrFail($vocabId);
            $this->vocabId       = $vocab->id;
            $this->word          = $vocab->word;
            $this->pronunciation = $vocab->pronunciation ?? '';
            $this->meaning       = $vocab->meaning;
            $this->description_en = $vocab->description_en ?? '';
            $this->example       = $vocab->example ?? '';
            $this->collocation   = $vocab->collocation ?? '';
            $this->related_words = $vocab->related_words ?? '';
            $this->note          = $vocab->note ?? '';
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'set_id'        => $this->setId,
            'word'          => $this->word,
            'pronunciation' => $this->pronunciation,
            'meaning'       => $this->meaning,
            'description_en' => $this->description_en,
            'example'       => $this->example,
            'collocation'   => $this->collocation,
            'related_words' => $this->related_words,
            'note'          => $this->note,
        ];

        if ($this->vocabId) {
            Vocabulary::where('set_id', $this->setId)->findOrFail($this->vocabId)->update($data);
        } else {
            Vocabulary::create($data);
        }

        return redirect()->route('vocabulary.words', $this->setId)->with('message', 'Đã lưu từ vựng!');
    }

    public function render()
    {
        return view('livewire.vocabulary.vocabulary-form');
    }
}
```

- [ ] **Step 5: Thêm routes**

```php
// routes/web.php - trong middleware auth group
Route::get('/vocabulary/sets', VocabularySetIndex::class)->name('vocabulary.sets');
Route::get('/vocabulary/sets/create', VocabularySetForm::class)->name('vocabulary.sets.create');
Route::get('/vocabulary/sets/{setId}/edit', VocabularySetForm::class)->name('vocabulary.sets.edit');
Route::get('/vocabulary/sets/{setId}/words', VocabularyIndex::class)->name('vocabulary.words');
Route::get('/vocabulary/sets/{setId}/words/create', VocabularyForm::class)->name('vocabulary.words.create');
Route::get('/vocabulary/sets/{setId}/words/{vocabId}/edit', VocabularyForm::class)->name('vocabulary.words.edit');
```

- [ ] **Step 6: Commit**

```bash
git add app/Http/Livewire/Vocabulary/ resources/views/livewire/vocabulary/ routes/web.php
git commit -m "feat: add vocabulary set and word CRUD with Livewire"
git push
```

---

## Task 6: Import Excel/CSV (Dev 2 - Ngày 4, ~2h)

**Files:**
- Create: `app/Imports/VocabularyImport.php`
- Create: `app/Http/Livewire/Vocabulary/VocabularyImport.php`
- Create: `storage/app/templates/vocabulary_template.xlsx`

- [ ] **Step 1: Tạo Import class**

```bash
php artisan make:import VocabularyImport --model=Vocabulary
```

- [ ] **Step 2: Viết `app/Imports/VocabularyImport.php`**

```php
<?php

namespace App\Imports;

use App\Models\Vocabulary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class VocabularyImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    private int $setId;

    public function __construct(int $setId)
    {
        $this->setId = $setId;
    }

    /**
     * Mỗi row trong Excel map thành 1 Vocabulary model.
     * Header row: word | pronunciation | meaning | description_en | example | collocation | note
     */
    public function model(array $row): Vocabulary
    {
        return new Vocabulary([
            'set_id'         => $this->setId,
            'word'           => $row['word'],
            'pronunciation'  => $row['pronunciation'] ?? null,
            'meaning'        => $row['meaning'],
            'description_en' => $row['description_en'] ?? null,
            'example'        => $row['example'] ?? null,
            'collocation'    => $row['collocation'] ?? null,
            'note'           => $row['note'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'word'    => 'required|string',
            'meaning' => 'required|string',
        ];
    }
}
```

- [ ] **Step 3: Tạo Livewire Upload component**

```bash
php artisan make:livewire Vocabulary/VocabularyImportForm
```

```php
<?php

namespace App\Http\Livewire\Vocabulary;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VocabularyImport;
use App\Models\VocabularySet;
use Illuminate\Support\Facades\Auth;

class VocabularyImportForm extends Component
{
    use WithFileUploads;

    public int $setId;
    public $file = null; // uploaded file

    protected array $rules = [
        'file' => 'required|file|mimes:xlsx,csv|max:2048',
    ];

    public function mount(int $setId): void
    {
        VocabularySet::where('user_id', Auth::id())->findOrFail($setId);
        $this->setId = $setId;
    }

    public function import(): void
    {
        $this->validate();

        Excel::import(new VocabularyImport($this->setId), $this->file->getRealPath());

        session()->flash('message', 'Import thành công!');
        return redirect()->route('vocabulary.words', $this->setId);
    }

    public function render()
    {
        return view('livewire.vocabulary.import-form');
    }
}
```

- [ ] **Step 4: Commit**

```bash
git add app/Imports/ app/Http/Livewire/Vocabulary/VocabularyImportForm.php
git commit -m "feat: add Excel/CSV import for vocabulary words"
git push
```

---

## Task 7: Flashcard Learning Component (Dev 3 - Ngày 2-3, ~4h)

**Files:**
- Create: `app/Http/Livewire/Learning/LearningSession.php`
- Create: `resources/views/livewire/learning/learning-session.blade.php`

- [ ] **Step 1: Tạo Livewire component**

```bash
php artisan make:livewire Learning/LearningSession
```

- [ ] **Step 2: Viết `app/Http/Livewire/Learning/LearningSession.php`**

```php
<?php

namespace App\Http\Livewire\Learning;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Vocabulary;
use App\Models\SrsProgress;
use App\Models\StudyLog;
use App\Models\VocabularySet;
use App\Services\SpacedRepetitionService;
use Carbon\Carbon;

class LearningSession extends Component
{
    public int $setId;
    public bool $isFlipped    = false;      // Thẻ đang lật hay không
    public bool $sessionDone  = false;      // Phiên học xong chưa
    public int $currentIndex  = 0;          // Index của từ hiện tại
    public array $wordIds     = [];         // Danh sách ID từ cần học hôm nay

    // Stats của phiên học
    public int $totalWords = 0;
    public int $doneWords  = 0;

    public function mount(int $setId): void
    {
        $user = Auth::user();
        VocabularySet::where('user_id', $user->id)->findOrFail($setId);
        $this->setId = $setId;

        $this->loadTodayWords();
    }

    /**
     * Lấy danh sách từ cần học hôm nay:
     * - Từ mới (chưa có SRS record)
     * - Từ đến hạn ôn (next_review_at <= now)
     */
    private function loadTodayWords(): void
    {
        $user = Auth::user();
        $goal = $user->dailyGoal;
        $newLimit    = $goal ? $goal->new_words_per_day : 10;
        $reviewLimit = $goal ? $goal->review_words_per_day : 20;

        // Từ đến hạn ôn
        $reviewIds = SrsProgress::where('user_id', $user->id)
            ->where('next_review_at', '<=', Carbon::now())
            ->whereHas('vocabulary', fn($q) => $q->where('set_id', $this->setId))
            ->limit($reviewLimit)
            ->pluck('vocabulary_id')
            ->toArray();

        // Từ mới (chưa học lần nào)
        $learnedIds = SrsProgress::where('user_id', $user->id)->pluck('vocabulary_id')->toArray();
        $newIds = Vocabulary::where('set_id', $this->setId)
            ->whereNotIn('id', $learnedIds)
            ->limit($newLimit)
            ->pluck('id')
            ->toArray();

        $this->wordIds   = array_merge($reviewIds, $newIds);
        $this->totalWords = count($this->wordIds);

        if ($this->totalWords === 0) {
            $this->sessionDone = true;
        }
    }

    public function getCurrentWordProperty(): ?Vocabulary
    {
        if ($this->currentIndex >= count($this->wordIds)) {
            return null;
        }
        return Vocabulary::find($this->wordIds[$this->currentIndex]);
    }

    public function flipCard(): void
    {
        $this->isFlipped = !$this->isFlipped;
    }

    /**
     * User đánh giá từ hiện tại.
     * @param string $rating again|hard|good|easy
     */
    public function rate(string $rating): void
    {
        if (!in_array($rating, ['again', 'hard', 'good', 'easy'])) {
            return;
        }

        $vocabId = $this->wordIds[$this->currentIndex];
        $user    = Auth::user();
        $srs     = new SpacedRepetitionService();

        // Lấy SRS hiện tại hoặc tạo mới
        $progress = SrsProgress::firstOrNew([
            'user_id'       => $user->id,
            'vocabulary_id' => $vocabId,
        ]);

        // Tính toán SM-2
        $result = $srs->calculate(
            easeFactor: $progress->ease_factor ?? 2.5,
            intervalDays: $progress->interval_days ?? 1,
            repetitions: $progress->repetitions ?? 0,
            rating: $rating
        );

        // Lưu progress
        $progress->fill([
            'ease_factor'    => $result['ease_factor'],
            'interval_days'  => $result['interval_days'],
            'repetitions'    => $result['repetitions'],
            'next_review_at' => $result['next_review_at'],
            'last_reviewed_at' => Carbon::now(),
            'status'         => $result['status'],
        ])->save();

        // Ghi log
        StudyLog::create([
            'user_id'       => $user->id,
            'vocabulary_id' => $vocabId,
            'rating'        => $rating,
            'studied_at'    => Carbon::now(),
        ]);

        // Cập nhật streak
        $this->updateStreak($user);

        // Chuyển sang từ tiếp theo
        $this->doneWords++;
        $this->currentIndex++;
        $this->isFlipped = false;

        if ($this->currentIndex >= $this->totalWords) {
            $this->sessionDone = true;
        }
    }

    private function updateStreak(\App\Models\User $user): void
    {
        $today = Carbon::today();

        if ($user->last_study_date === null || !$user->last_study_date->isToday()) {
            $isConsecutive = $user->last_study_date && $user->last_study_date->isYesterday();

            $user->update([
                'streak_days'    => $isConsecutive ? $user->streak_days + 1 : 1,
                'last_study_date' => $today,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.learning.learning-session', [
            'currentWord' => $this->currentWord,
        ]);
    }
}
```

- [ ] **Step 3: Viết view `resources/views/livewire/learning/learning-session.blade.php`**

```blade
<div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center p-4">

    @if ($sessionDone)
        {{-- Màn hình kết thúc phiên học --}}
        <div class="text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Hoàn thành!</h2>
            <p class="text-gray-500 mb-6">Bạn đã ôn xong {{ $doneWords }} từ hôm nay.</p>
            <a href="{{ route('dashboard') }}"
               class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-colors cursor-pointer">
                Về Dashboard
            </a>
        </div>
    @elseif ($currentWord)
        {{-- Thanh tiến độ --}}
        <div class="w-full max-w-lg mb-6">
            <div class="flex justify-between text-sm text-gray-500 mb-1">
                <span>{{ $doneWords }}/{{ $totalWords }} từ</span>
                <span>{{ $totalWords > 0 ? round($doneWords / $totalWords * 100) : 0 }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500"
                     style="width: {{ $totalWords > 0 ? ($doneWords / $totalWords * 100) : 0 }}%"></div>
            </div>
        </div>

        {{-- Flashcard --}}
        <div class="w-full max-w-lg" x-data="{ flipped: @entangle('isFlipped') }">
            <div class="relative cursor-pointer" style="perspective: 1200px" wire:click="flipCard">
                <div class="relative transition-transform duration-500"
                     style="transform-style: preserve-3d; transform: {{ $isFlipped ? 'rotateY(180deg)' : 'rotateY(0deg)' }}; min-height: 280px">

                    {{-- Mặt trước - word --}}
                    <div class="absolute inset-0 bg-white rounded-2xl shadow-md border border-gray-100 flex flex-col items-center justify-center p-8"
                         style="backface-visibility: hidden">
                        <p class="text-xs text-indigo-400 uppercase tracking-widest mb-3">Từ vựng</p>
                        <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $currentWord->word }}</h1>
                        @if($currentWord->pronunciation)
                            <p class="text-gray-400 text-lg">/{{ $currentWord->pronunciation }}/</p>
                        @endif
                        <p class="text-sm text-gray-400 mt-6">Nhấn để xem nghĩa</p>
                    </div>

                    {{-- Mặt sau - meaning + example --}}
                    <div class="absolute inset-0 bg-indigo-50 rounded-2xl shadow-md border border-indigo-100 flex flex-col justify-center p-8"
                         style="backface-visibility: hidden; transform: rotateY(180deg)">
                        <p class="text-xs text-indigo-400 uppercase tracking-widest mb-3">Nghĩa</p>
                        <p class="text-2xl font-bold text-gray-800 mb-4">{{ $currentWord->meaning }}</p>

                        @if($currentWord->example)
                            <div class="border-l-4 border-indigo-300 pl-4 mb-3">
                                <p class="text-sm text-gray-600 italic">{{ $currentWord->example }}</p>
                            </div>
                        @endif

                        @if($currentWord->collocation)
                            <p class="text-xs text-gray-400">
                                <span class="font-semibold">Collocation:</span> {{ $currentWord->collocation }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Nút đánh giá - chỉ hiện sau khi lật thẻ --}}
            @if ($isFlipped)
                <div class="grid grid-cols-4 gap-3 mt-6">
                    <button wire:click="rate('again')"
                        class="py-3 rounded-xl text-sm font-semibold bg-red-100 text-red-700 hover:bg-red-200 transition-colors cursor-pointer">
                        Again
                    </button>
                    <button wire:click="rate('hard')"
                        class="py-3 rounded-xl text-sm font-semibold bg-orange-100 text-orange-700 hover:bg-orange-200 transition-colors cursor-pointer">
                        Hard
                    </button>
                    <button wire:click="rate('good')"
                        class="py-3 rounded-xl text-sm font-semibold bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors cursor-pointer">
                        Good
                    </button>
                    <button wire:click="rate('easy')"
                        class="py-3 rounded-xl text-sm font-semibold bg-green-100 text-green-700 hover:bg-green-200 transition-colors cursor-pointer">
                        Easy
                    </button>
                </div>
            @else
                <p class="text-center text-gray-400 text-sm mt-6">Lật thẻ trước khi đánh giá</p>
            @endif
        </div>
    @else
        <p class="text-gray-500">Không có từ nào để học hôm nay. Thêm bộ từ mới đi!</p>
    @endif
</div>
```

- [ ] **Step 4: Thêm route**

```php
Route::get('/learn/{setId}', LearningSession::class)->name('learn.session');
```

- [ ] **Step 5: Commit**

```bash
git add app/Http/Livewire/Learning/ resources/views/livewire/learning/
git commit -m "feat: add flashcard learning session with SM-2 integration"
git push
```

---

## Task 8: Progress Dashboard (Dev 3 - Ngày 4, ~2h)

**Files:**
- Create: `app/Http/Livewire/Dashboard/ProgressDashboard.php`
- Create: `resources/views/livewire/dashboard/progress-dashboard.blade.php`

- [ ] **Step 1: Tạo component**

```bash
php artisan make:livewire Dashboard/ProgressDashboard
```

- [ ] **Step 2: Viết `app/Http/Livewire/Dashboard/ProgressDashboard.php`**

```php
<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\SrsProgress;
use App\Models\StudyLog;
use Carbon\Carbon;

class ProgressDashboard extends Component
{
    public int $totalLearned   = 0;
    public int $totalMastered  = 0;
    public int $streakDays     = 0;
    public float $accuracy     = 0;
    public array $weeklyActivity = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->totalLearned  = SrsProgress::where('user_id', $user->id)
            ->whereIn('status', ['review', 'mastered'])->count();

        $this->totalMastered = SrsProgress::where('user_id', $user->id)
            ->where('status', 'mastered')->count();

        $this->streakDays = $user->streak_days;

        // Accuracy = % lần đánh giá good/easy trong 7 ngày gần nhất
        $recentLogs = StudyLog::where('user_id', $user->id)
            ->where('studied_at', '>=', Carbon::now()->subDays(7))
            ->get();

        if ($recentLogs->count() > 0) {
            $goodCount = $recentLogs->whereIn('rating', ['good', 'easy'])->count();
            $this->accuracy = round($goodCount / $recentLogs->count() * 100, 1);
        }

        // Activity 7 ngày
        $this->weeklyActivity = collect(range(6, 0))->map(function ($daysAgo) use ($user) {
            $date = Carbon::today()->subDays($daysAgo);
            $count = StudyLog::where('user_id', $user->id)
                ->whereDate('studied_at', $date)
                ->count();
            return [
                'date'  => $date->format('d/m'),
                'count' => $count,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.progress-dashboard');
    }
}
```

- [ ] **Step 3: Commit**

```bash
git add app/Http/Livewire/Dashboard/ resources/views/livewire/dashboard/
git commit -m "feat: add progress dashboard with streak, accuracy, weekly chart"
git push
```

---

## Task 9: Notification System (Dev 4 - Ngày 2-3, ~3h)

**Files:**
- Create: `app/Jobs/SendDailyReminderJob.php`
- Create: `app/Notifications/DailyStudyReminder.php`
- Create: `app/Console/Commands/ScheduleDailyReminders.php`
- Modify: `routes/console.php`

- [ ] **Step 1: Tạo Notification và Job**

```bash
php artisan make:notification DailyStudyReminder
php artisan make:job SendDailyReminderJob
php artisan make:command ScheduleDailyReminders
```

- [ ] **Step 2: Viết `app/Notifications/DailyStudyReminder.php`**

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DailyStudyReminder extends Notification
{
    private int $dueWordsCount;

    public function __construct(int $dueWordsCount)
    {
        $this->dueWordsCount = $dueWordsCount;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('MinLish - Đến giờ học từ vựng rồi!')
            ->greeting("Xin chào {$notifiable->name}!")
            ->line("Hôm nay bạn có **{$this->dueWordsCount} từ** cần ôn lại.")
            ->action('Học ngay', url('/dashboard'))
            ->line('Duy trì streak của bạn nhé!');
    }
}
```

- [ ] **Step 3: Viết `app/Jobs/SendDailyReminderJob.php`**

```php
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\SrsProgress;
use App\Notifications\DailyStudyReminder;
use Carbon\Carbon;

class SendDailyReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $user = User::find($this->userId);
        if (!$user) return;

        // Đếm số từ cần ôn hôm nay
        $dueCount = SrsProgress::where('user_id', $this->userId)
            ->where('next_review_at', '<=', Carbon::now())
            ->count();

        if ($dueCount > 0) {
            $user->notify(new DailyStudyReminder($dueCount));
        }
    }
}
```

- [ ] **Step 4: Viết `app/Console/Commands/ScheduleDailyReminders.php`**

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\SendDailyReminderJob;

class ScheduleDailyReminders extends Command
{
    protected $signature = 'minlish:send-reminders';
    protected $description = 'Gửi reminder học từ vựng cho tất cả user';

    public function handle(): int
    {
        $users = User::all();

        foreach ($users as $user) {
            // Dispatch vào Queue để không treo server
            SendDailyReminderJob::dispatch($user->id);
        }

        $this->info("Đã đưa {$users->count()} reminder vào queue.");
        return Command::SUCCESS;
    }
}
```

- [ ] **Step 5: Đăng ký cron trong `routes/console.php`**

```php
<?php

use Illuminate\Support\Facades\Schedule;

// Gửi reminder mỗi ngày lúc 8:00 sáng
Schedule::command('minlish:send-reminders')->dailyAt('08:00');
```

- [ ] **Step 6: Config Queue (dùng database driver)**

```bash
php artisan queue:table
php artisan migrate
```

Thêm vào `.env`:
```
QUEUE_CONNECTION=database
```

- [ ] **Step 7: Commit**

```bash
git add app/Jobs/ app/Notifications/ app/Console/ routes/console.php
git commit -m "feat: add daily reminder notification system with queue"
git push
```

---

## Task 10: Layout & Navigation (Dev 3 - Ngày 1, ~2h)

**Files:**
- Modify: `resources/views/layouts/app.blade.php`
- Create: `resources/views/components/nav-link.blade.php`

- [ ] **Step 1: Viết main layout `resources/views/layouts/app.blade.php`**

```blade
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'MinLish') }} - {{ $title ?? 'Học từ vựng' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <span class="text-2xl font-black text-indigo-600">MinLish</span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('vocabulary.sets') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('vocabulary.*') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                        Bộ từ vựng
                    </a>
                </div>

                {{-- User menu --}}
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 hidden md:block">{{ Auth::user()->name }}</span>
                    <a href="{{ route('profile') }}"
                       class="w-9 h-9 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center text-sm font-bold hover:bg-indigo-200 transition-colors cursor-pointer">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-red-500 transition-colors cursor-pointer">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if (session('message'))
        <div class="max-w-6xl mx-auto px-4 pt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">
                {{ session('message') }}
            </div>
        </div>
    @endif

    {{-- Main content --}}
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/layouts/
git commit -m "feat: add main layout with sticky navbar and flash messages"
git push
```

---

## Task 11: QC - Test Cases Checklist (QC - Ngày 4-5)

### Functional Testing

- [ ] **Auth**
  - [ ] Đăng ký email/password thành công
  - [ ] Đăng nhập sai password hiển thị lỗi
  - [ ] Cập nhật profile lưu được
  - [ ] Đặt daily goal lưu được

- [ ] **Vocabulary Management**
  - [ ] Tạo bộ từ mới thành công
  - [ ] Xoá bộ từ (xoá cascade từ bên trong)
  - [ ] Thêm từ vựng với đủ fields
  - [ ] Sửa từ vựng
  - [ ] Xoá từ vựng
  - [ ] Import file Excel đúng format thành công
  - [ ] Import file sai format hiện lỗi validation

- [ ] **Flashcard Learning**
  - [ ] Lật thẻ hoạt động
  - [ ] 4 nút đánh giá chỉ hiện sau khi lật
  - [ ] Đánh giá "again" → từ quay lại queue
  - [ ] Đánh giá "easy" → interval tăng đúng
  - [ ] Streak tăng khi học ngày mới
  - [ ] Màn hình "Hoàn thành" hiện khi học xong

- [ ] **Dashboard**
  - [ ] Tổng số từ đã học hiển thị đúng
  - [ ] Streak ngày hiển thị đúng
  - [ ] Accuracy % tính đúng
  - [ ] Biểu đồ 7 ngày hiển thị đúng

### Non-functional Testing

- [ ] **Responsive** (Mobile 375px, Tablet 768px, Desktop 1440px)
  - [ ] Navbar mobile hiển thị đúng
  - [ ] Flashcard card mobile đủ lớn để tap
  - [ ] Form inputs không bị crop

- [ ] **Performance**
  - [ ] Trang load < 2s trên mạng bình thường

---

## Task 12: Deploy (Dev 1 - Ngày 5, ~2h)

- [ ] **Step 1: Chuẩn bị `.env.production`**

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=minlish_db
DB_USERNAME=minlish_user
DB_PASSWORD=your_password

QUEUE_CONNECTION=database
MAIL_MAILER=smtp
```

- [ ] **Step 2: Optimize cho production**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
npm run build
```

- [ ] **Step 3: Chạy migrations trên server**

```bash
php artisan migrate --force
```

- [ ] **Step 4: Khởi động Queue Worker**

```bash
php artisan queue:work --daemon
```

- [ ] **Step 5: Kiểm tra deploy**

Truy cập domain, test đăng ký → đăng nhập → thêm từ → học flashcard.

- [ ] **Step 6: Tag release**

```bash
git tag v1.0.0
git push origin v1.0.0
```

---

## Tổng Kết Ngày Học

| Ngày | Dev 1 | Dev 2 | Dev 3 | Dev 4 | QC |
|------|-------|-------|-------|-------|----|
| 1 | Task 1 (Setup + Migrations) + Task 2 (Models) | Task 4 skeleton | Task 10 (Layout) | Task 9 skeleton | Review spec |
| 2 | Task 3 (SM-2 Service) | Task 4 (Profile) | Task 7 (Flashcard UI) | Task 9 (Notification) | Test ngày 1 |
| 3 | Debug + Support | Task 5 (Vocab CRUD) | Task 7 (Learning Session) | Task 9 (Queue) | Test ngày 2 |
| 4 | Test + Fix | Task 6 (Import) | Task 8 (Dashboard) | Debug | Test ngày 3 |
| 5 | Task 12 (Deploy) | Polish + Bug fix | Responsive | QC Support | Final E2E |

---

## Conventions Code (OOP - Student Friendly)

1. **Một class = một trách nhiệm**: `SpacedRepetitionService` chỉ làm tính toán SM-2, không đụng database.
2. **Tên rõ ràng**: `loadTodayWords()` > `getData()`.
3. **Comment tiếng Việt**: Docblock giải thích *tại sao*, không giải thích *cái gì*.
4. **Livewire component**: mỗi file chỉ render 1 tính năng cụ thể.
5. **Validation ở method `rules()`**: không validate trong `save()`.
6. **Route group**: tất cả route cần auth đặt trong `middleware('auth')` group.
7. **Commit nhỏ, thường xuyên**: mỗi tính năng nhỏ = 1 commit.
