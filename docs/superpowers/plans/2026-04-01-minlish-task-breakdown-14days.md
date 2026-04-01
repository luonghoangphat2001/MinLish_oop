# MinLish — Task Breakdown 14 Ngày (4 Dev + 1 QC)

**Project:** MinLish - Ứng Dụng Học Từ Vựng Tiếng Anh
**Stack:** Laravel 11 + Livewire 3 + Tailwind CSS 3 + AlpineJS + MySQL 8
**Team:** Dev 1, Dev 2, Dev 3, Dev 4, QC
**Timeline:** 14 ngày / 4 Sprint

---

## Phân Chia Sprint

| Sprint | Ngày | Mục tiêu |
|--------|------|-----------|
| Sprint 1 | N1–N3 | Foundation: Setup, DB, Models, Auth |
| Sprint 2 | N4–N7 | Core: Vocab CRUD, SRS Engine, Flashcard |
| Sprint 3 | N8–N11 | Features: Import/Export, Dashboard, Notifications |
| Sprint 4 | N12–N14 | Polish: Test, Responsive, Deploy |

---

## Phân Công Tổng Quan

| Task | Tiêu đề | Assignee | Sprint | Deps |
|------|---------|----------|--------|------|
| T01 | Khởi tạo Laravel Project & GitHub | Dev 1 | S1 | — |
| T02 | Cấu hình Tailwind + AlpineJS + Layout Skeleton | Dev 3 | S1 | T01 |
| T03 | Migration: Users & Auth Fields | Dev 1 | S1 | T01 |
| T04 | Migration: Vocabulary & Learning Tables | Dev 1 | S1 | T03 |
| T05 | Eloquent Models & Relationships | Dev 1 | S1 | T03, T04 |
| T06 | User Registration & Login (Breeze) | Dev 2 | S1 | T01, T03 |
| T07 | User Profile Page (Livewire) | Dev 2 | S1 | T05, T06 |
| T08 | Google OAuth Login | Dev 2 | S1 | T06 |
| T09 | Seeders & Factory Dữ Liệu Mẫu | Dev 1 | S1 | T05 |
| T10 | Vocabulary Set CRUD (Livewire) | Dev 2 | S2 | T05, T06 |
| T11 | Vocabulary CRUD trong Set (Livewire) | Dev 2 | S2 | T10 |
| T12 | SpacedRepetitionService (SM-2) | Dev 1 | S2 | T05 |
| T13 | SRS Progress Initialization | Dev 1 | S2 | T05, T12 |
| T14 | Daily Plan Component (Livewire) | Dev 1 | S2 | T12, T13 |
| T15 | Flashcard Component (Livewire + AlpineJS) | Dev 3 | S2 | T11, T12 |
| T16 | Learning Session Flow | Dev 3 | S2 | T14, T15 |
| T17 | Daily Goals Settings | Dev 2 | S2 | T05, T07 |
| T18 | Import Vocabulary từ Excel/CSV | Dev 2 | S3 | T11 |
| T19 | Export Vocabulary Set ra Excel | Dev 2 | S3 | T11 |
| T20 | Progress Dashboard (Livewire) | Dev 3 | S3 | T16 |
| T21 | Activity Chart Component (Chart.js) | Dev 3 | S3 | T20 |
| T22 | Streak Tracking System | Dev 1 | S3 | T16 |
| T23 | Notification: Daily Reminder (Email) | Dev 4 | S3 | T05 |
| T24 | Notification: Review Reminder | Dev 4 | S3 | T23 |
| T25 | Public Vocabulary Sets (Browse & Clone) | Dev 2 | S3 | T10 |
| T26 | Search Từ Vựng Global | Dev 3 | S3 | T11 |
| T27 | QC: Viết Test Cases & Test Sprint 1–2 | QC | S3 | T09, T16 |
| T28 | QC: Test Sprint 3 | QC | S3 | T18, T20, T23, T27 |
| T29 | Responsive Design (Mobile/Tablet) | Dev 3 | S4 | T15, T20, T26 |
| T30 | Unit Tests: SpacedRepetitionService | Dev 1 | S4 | T12 |
| T31 | Feature Tests: Livewire Components | Dev 1 | S4 | T11, T15 |
| T32 | Performance: DB Indexing & Query Optimization | Dev 1 | S4 | T04, T12 |
| T33 | Bug Fix: Xử Lý Lỗi & Validation Edge Cases | Dev 2 | S4 | T27, T28 |
| T34 | UI Polish: Toast & Loading States | Dev 3 | S4 | T10, T11, T15 |
| T35 | Cấu Hình Môi Trường Production | Dev 1 | S4 | T23 |
| T36 | Deploy lên Server | Dev 1 | S4 | T35, T32 |
| T37 | Setup CI/CD GitHub Actions | Dev 1 | S4 | T30, T31, T36 |
| T38 | QC: Final E2E Testing | QC | S4 | T36 |
| T39 | Documentation: README & User Guide | Dev 4 | S4 | T36 |
| T40 | Retrospective & Handoff | Tất cả | S4 | T38 |

---

## SPRINT 1 — Foundation (Ngày 1–3)

---

### T01 — Khởi tạo Laravel Project & GitHub
**Assignee:** Dev 1 | **Ngày:** 1 | **Deps:** —

Tạo Laravel 11 project mới, cài Laravel Breeze (Livewire stack), cấu hình `.env`, kết nối GitHub repo `MinLish_oop`. Push commit đầu tiên lên `main`. Đây là task nền tảng, mọi task khác phụ thuộc vào.

**Checklist:**
- [ ] Tạo Laravel project mới với `composer create-project`
- [ ] Cài Laravel Breeze với `breeze:install livewire`
- [ ] Cài thêm packages: `livewire/livewire`, `maatwebsite/excel`
- [ ] Cấu hình `.env` (DB, APP_URL)
- [ ] `git init`, remote add origin, push lên main

---

### T02 — Cấu hình Tailwind CSS + AlpineJS + Layout Skeleton
**Assignee:** Dev 3 | **Ngày:** 1 | **Deps:** T01

Cài Tailwind CSS 3, `@tailwindcss/forms`, `@tailwindcss/typography`, AlpineJS 3. Tạo 2 layout blade: `app.blade.php` (sau login) và `guest.blade.php` (login/register). Đây là khung dùng cho tất cả Livewire components về sau. Chỉ cần skeleton header/sidebar/footer — chưa cần nội dung.

**Checklist:**
- [ ] `npm install -D tailwindcss @tailwindcss/forms @tailwindcss/typography alpinejs`
- [ ] Cấu hình `tailwind.config.js` với content paths cho blade + livewire
- [ ] Tạo `resources/views/layouts/app.blade.php` với sidebar navigation
- [ ] Tạo `resources/views/layouts/guest.blade.php` cho auth pages
- [ ] `npm run build` và verify styles load đúng

---

### T03 — Migration: Users & Auth Fields
**Assignee:** Dev 1 | **Ngày:** 1 | **Deps:** T01

Tạo migration `add_profile_fields_to_users_table` thêm các cột: `google_id`, `level` (ENUM A1–C2), `goal` (string), `streak_days` (int, default 0), `last_study_date` (date, nullable). Chạy `php artisan migrate`. Đây là bước đầu của DB schema.

**Checklist:**
- [ ] Tạo migration file với `php artisan make:migration`
- [ ] Viết `up()`: thêm cột google_id, level, goal, streak_days, last_study_date
- [ ] Viết `down()`: `dropColumn` tất cả cột đã thêm
- [ ] `php artisan migrate` thành công

---

### T04 — Migration: Vocabulary & Learning Tables
**Assignee:** Dev 1 | **Ngày:** 1 | **Deps:** T03

Tạo migrations cho 5 bảng còn lại: `vocabulary_sets`, `vocabularies`, `srs_progress` (unique constraint user+vocab), `study_logs`, `daily_goals`. Chạy migrate. Đây là toàn bộ schema cần thiết cho ứng dụng.

**Checklist:**
- [ ] Migration `create_vocabulary_sets_table`: id, user_id (FK), name, description, tags (JSON), is_public, timestamps
- [ ] Migration `create_vocabularies_table`: id, set_id (FK), word, pronunciation, meaning, description_en, example, collocation, related_words, note, timestamps
- [ ] Migration `create_srs_progress_table`: id, user_id (FK), vocabulary_id (FK), ease_factor (float, 2.5), interval_days (int, 1), repetitions (int, 0), next_review_at, last_reviewed_at, status (ENUM), unique(user_id, vocabulary_id)
- [ ] Migration `create_study_logs_table`: id, user_id (FK), vocabulary_id (FK), rating (ENUM: again/hard/good/easy), studied_at, timestamps
- [ ] Migration `create_daily_goals_table`: id, user_id (FK, unique), new_words_per_day (10), review_words_per_day (20), timestamps
- [ ] `php artisan migrate` thành công — tất cả 6 bảng tồn tại

---

### T05 — Eloquent Models & Relationships
**Assignee:** Dev 1 | **Ngày:** 2 | **Deps:** T03, T04

Tạo 6 model: `User` (cập nhật), `VocabularySet`, `Vocabulary`, `SrsProgress`, `StudyLog`, `DailyGoal`. Định nghĩa đầy đủ `$fillable`, `$casts`, và relationships (hasMany/belongsTo/hasOne). Đây là lớp data access dùng cho tất cả các tầng trên.

**Checklist:**
- [ ] `php artisan make:model VocabularySet VocabularySet Vocabulary SrsProgress StudyLog DailyGoal`
- [ ] `User`: thêm fillable fields mới, casts, relationships đến vocabularySets/srsProgresses/studyLogs/dailyGoal
- [ ] `VocabularySet`: fillable, cast tags→array, cast is_public→boolean, relationships user/vocabularies
- [ ] `Vocabulary`: fillable, relationships set/srsProgress, helper method `userProgress(int $userId)`
- [ ] `SrsProgress`: fillable, casts timestamps, relationships user/vocabulary
- [ ] `StudyLog`: fillable, casts studied_at, relationships user/vocabulary
- [ ] `DailyGoal`: fillable, relationship user

---

### T06 — User Registration & Login (Breeze)
**Assignee:** Dev 2 | **Ngày:** 1 | **Deps:** T01, T03

Cài Laravel Breeze Livewire stack (đã cài trong T01). Kiểm tra flow đăng ký/đăng nhập/logout mặc định hoạt động. Thêm middleware `auth` cho các routes cần bảo vệ trong `routes/web.php`. Cơ sở cho T07, T08.

**Checklist:**
- [ ] Verify trang `/register`, `/login`, `/logout` hoạt động
- [ ] Thêm route group middleware `auth` bao quanh routes sẽ tạo sau
- [ ] Redirect sau login đến `/dashboard`
- [ ] Test đăng ký user mới → đăng nhập → logout thành công

---

### T07 — User Profile Page (Livewire)
**Assignee:** Dev 2 | **Ngày:** 2 | **Deps:** T05, T06

Tạo Livewire component `Auth/ProfileEdit.php` + blade `profile-edit.blade.php`. Form cho phép user cập nhật: name, level (A1–C2), goal (IELTS/giao_tiếp/business), mật khẩu. Validation realtime với Livewire `#[Rule]`. Phụ thuộc T05 để save vào cột mới của users.

**Checklist:**
- [ ] `php artisan make:livewire Auth/ProfileEdit`
- [ ] Form fields: name, email (readonly), level (select), goal (select), new_password, confirm_password
- [ ] Livewire validation rules cho tất cả fields
- [ ] Save action cập nhật User model
- [ ] Toast hoặc alert "Cập nhật thành công"
- [ ] Route `/profile` → page blade chứa component

---

### T08 — Google OAuth Login
**Assignee:** Dev 2 | **Ngày:** 3 | **Deps:** T06

Cài `laravel/socialite`, cấu hình Google OAuth credentials trong `.env`. Tạo route + controller xử lý redirect và callback, lưu `google_id` vào bảng users. Cho phép user đăng nhập bằng Google Account thay vì email/password.

**Checklist:**
- [ ] `composer require laravel/socialite`
- [ ] Thêm `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI` vào `.env.example`
- [ ] Cấu hình `config/services.php`
- [ ] Tạo `SocialiteController` với method `redirectToGoogle()` và `handleGoogleCallback()`
- [ ] Callback: tìm user theo google_id hoặc email → tạo mới nếu chưa có → login
- [ ] Thêm nút "Đăng nhập với Google" vào trang login

---

### T09 — Seeders & Factory Dữ Liệu Mẫu
**Assignee:** Dev 1 | **Ngày:** 3 | **Deps:** T05

Tạo factories cho `User`, `VocabularySet`, `Vocabulary`. Tạo `DatabaseSeeder` với 5 user mẫu + 2 bộ từ (50 từ/bộ). Dùng để test các task tiếp theo mà không cần nhập tay dữ liệu. QC cần để chạy test cases.

**Checklist:**
- [ ] `php artisan make:factory UserFactory VocabularySetFactory VocabularyFactory`
- [ ] `UserFactory`: fake name, email, password, level, goal
- [ ] `VocabularySetFactory`: fake name, description, tags array
- [ ] `VocabularyFactory`: fake word (tiếng Anh), pronunciation, meaning (tiếng Việt), example
- [ ] `DatabaseSeeder`: tạo 5 users, mỗi user 2 sets, mỗi set 50 vocabularies
- [ ] `php artisan db:seed` thành công

---

## SPRINT 2 — Core Features (Ngày 4–7)

---

### T10 — Vocabulary Set CRUD (Livewire)
**Assignee:** Dev 2 | **Ngày:** 4 | **Deps:** T05, T06

Tạo 2 Livewire components: `VocabularySetIndex.php` (danh sách, search theo name, filter theo tags) và `VocabularySetForm.php` (modal tạo/sửa set với name, description, tags JSON, is_public toggle). Chỉ hiển thị set của user hiện tại. Có nút tạo/sửa/xóa với confirm dialog.

**Checklist:**
- [ ] `php artisan make:livewire Vocabulary/VocabularySetIndex`
- [ ] `php artisan make:livewire Vocabulary/VocabularySetForm`
- [ ] Index: list sets của auth user, search realtime, hiển thị word count
- [ ] Form: modal với validation (name required, max 255)
- [ ] Xóa set với confirm dialog (AlpineJS `x-confirm`)
- [ ] Route `/vocabulary/sets` → page blade
- [ ] Link từ sidebar navigation (T02)

---

### T11 — Vocabulary CRUD trong Set (Livewire)
**Assignee:** Dev 2 | **Ngày:** 4–5 | **Deps:** T10

Tạo `VocabularyIndex.php` (danh sách từ trong một set, phân trang 20 từ/trang) và `VocabularyForm.php` (form thêm/sửa từ với đầy đủ fields: word, pronunciation, meaning, example, collocation, related_words, note). Cần T10 xong để có set_id điều hướng.

**Checklist:**
- [ ] `php artisan make:livewire Vocabulary/VocabularyIndex`
- [ ] `php artisan make:livewire Vocabulary/VocabularyForm`
- [ ] Index: danh sách từ của một set, phân trang, hiển thị word + meaning + status SRS
- [ ] Form: tất cả fields với validation (word required, meaning required)
- [ ] Inline edit hoặc modal edit
- [ ] Xóa từ với confirm
- [ ] Route `/vocabulary/sets/{set}/words`

---

### T12 — SpacedRepetitionService (SM-2 Algorithm)
**Assignee:** Dev 1 | **Ngày:** 4 | **Deps:** T05

Tạo `app/Services/SpacedRepetitionService.php` implement thuật toán SM-2: nhận vào `ease_factor`, `interval_days`, `repetitions`, `rating` (0–5) → tính toán và trả về giá trị mới cho `ease_factor`, `interval_days`, `repetitions`, `next_review_at`, `status`. Đây là engine học tập cốt lõi.

**Checklist:**
- [ ] Tạo class `SpacedRepetitionService` trong `app/Services/`
- [ ] Method `calculate(SrsProgress $progress, string $rating): array`
- [ ] Mapping rating → quality score: again=0, hard=2, good=4, easy=5
- [ ] SM-2 formula: new_EF = EF + (0.1 - (5-q)*(0.08+(5-q)*0.02))
- [ ] EF không xuống dưới 1.3
- [ ] interval: repetitions=0→1, repetitions=1→6, repetitions>1→round(interval*EF)
- [ ] Status logic: again→learning, hard→learning, good→review, easy→mastered
- [ ] Method `getWordsForReview(User $user): Collection` — từ có next_review_at <= now()
- [ ] Method `getNewWords(User $user, int $limit): Collection` — từ status=new

---

### T13 — SRS Progress Initialization
**Assignee:** Dev 1 | **Ngày:** 5 | **Deps:** T05, T12

Khi user bắt đầu học một set lần đầu, tạo bản ghi `srs_progress` (status=`new`, ease_factor=2.5) cho tất cả vocabulary trong set đó. Implement method `initializeProgress(User $user, VocabularySet $set)` trong `SpacedRepetitionService`. Cần thiết trước khi có Flashcard hoặc Daily Plan.

**Checklist:**
- [ ] Method `initializeProgress(User $user, VocabularySet $set): void` trong service
- [ ] Dùng `upsert` hoặc `firstOrCreate` để không duplicate
- [ ] Chỉ tạo records cho từ chưa có progress
- [ ] Trigger: khi user click "Học set này" từ trang VocabularySetIndex (T10)
- [ ] Test: sau init, đếm srs_progress records = số từ trong set

---

### T14 — Daily Plan Component (Livewire)
**Assignee:** Dev 1 | **Ngày:** 5 | **Deps:** T12, T13

Tạo `Learning/DailyPlan.php` hiển thị tổng quan kế hoạch học hôm nay: số từ mới cần học (theo daily_goals), số từ cần review (next_review_at <= today), progress bar, nút "Bắt đầu học" điều hướng đến LearningSession. Cần SRS Progress records đã init từ T13.

**Checklist:**
- [ ] `php artisan make:livewire Learning/DailyPlan`
- [ ] Hiển thị: new words count, review words count, total today
- [ ] Progress bar: số từ đã học hôm nay / tổng kế hoạch
- [ ] Nút "Học từ mới" và "Ôn tập" riêng biệt (hoặc gộp)
- [ ] Nếu hoàn thành mục tiêu → hiện thông báo chúc mừng + streak
- [ ] Route `/learning/today`

---

### T15 — Flashcard Component (Livewire + AlpineJS)
**Assignee:** Dev 3 | **Ngày:** 5–6 | **Deps:** T11, T12

Tạo `Learning/FlashCard.php` + blade `flash-card.blade.php`. Logic: hiển thị mặt trước (word + pronunciation) → user click "Lật" → flip animation bằng AlpineJS → hiện mặt sau (meaning, example, note) → user chọn rating (again/hard/good/easy). Gọi `SpacedRepetitionService` cập nhật `srs_progress`. Không reload page.

**Checklist:**
- [ ] `php artisan make:livewire Learning/FlashCard`
- [ ] Flip animation CSS (rotateY 180deg) control bằng AlpineJS `x-data`
- [ ] Mặt trước: word (lớn), pronunciation, nút "Lật thẻ"
- [ ] Mặt sau: meaning, example, collocation, 4 nút rating với màu khác nhau
- [ ] Livewire method `submitRating(string $rating)` → gọi service → load từ tiếp theo
- [ ] Hiển thị số thứ tự "Từ 3/20"
- [ ] Keyboard shortcuts: Space=lật, 1=again, 2=hard, 3=good, 4=easy

---

### T16 — Learning Session Flow (Livewire)
**Assignee:** Dev 3 | **Ngày:** 6 | **Deps:** T14, T15

Tạo `Learning/LearningSession.php` điều phối một phiên học hoàn chỉnh: load danh sách từ cần học hôm nay, lần lượt hiển thị Flashcard component, ghi `study_logs` sau mỗi đánh giá, cập nhật streak (T22 implement sau), hiện màn hình kết quả cuối phiên.

**Checklist:**
- [ ] `php artisan make:livewire Learning/LearningSession`
- [ ] Load queue từ: new words trước, review words sau
- [ ] Ghi `StudyLog` record mỗi lần submit rating
- [ ] Màn hình kết quả: số từ đã học, phân bổ rating, thời gian, streak badge
- [ ] Nút "Học thêm" (nếu còn từ) hoặc "Xong hôm nay"
- [ ] Route `/learning/session`

---

### T17 — Daily Goals Settings
**Assignee:** Dev 2 | **Ngày:** 6 | **Deps:** T05, T07

Thêm section "Mục tiêu học tập" vào trang Profile (T07): form cho phép user đặt `new_words_per_day` (mặc định 10) và `review_words_per_day` (mặc định 20). Tạo hoặc cập nhật record trong bảng `daily_goals`. Ảnh hưởng trực tiếp đến số từ hiển thị trong Daily Plan (T14).

**Checklist:**
- [ ] Thêm section vào `ProfileEdit` component hoặc tạo component riêng
- [ ] `firstOrCreate` DailyGoal khi user save
- [ ] Validation: new_words min 1 max 100, review_words min 0 max 200
- [ ] Hiển thị current values khi load trang

---

## SPRINT 3 — Extended Features (Ngày 8–11)

---

### T18 — Import Vocabulary từ Excel/CSV
**Assignee:** Dev 2 | **Ngày:** 8 | **Deps:** T11

Cài `maatwebsite/excel` (đã trong composer). Tạo Livewire component upload file Excel/CSV. Tạo `VocabularyImport` class xử lý từng row, validate (word required, meaning required), insert batch vào DB. Cung cấp file template Excel mẫu để user tải về.

**Checklist:**
- [ ] Tạo `app/Imports/VocabularyImport.php` implements `ToModel`, `WithHeadingRow`, `WithValidation`
- [ ] Column mapping: word, pronunciation, meaning, description_en, example, collocation, related_words, note
- [ ] Validation rules per row: word required, meaning required
- [ ] Livewire component với file upload, progress, kết quả (X imported, Y errors)
- [ ] Tạo file template `storage/app/templates/vocabulary-template.xlsx`
- [ ] Nút download template
- [ ] Route và link từ trang VocabularyIndex (T11)

---

### T19 — Export Vocabulary Set ra Excel
**Assignee:** Dev 2 | **Ngày:** 8 | **Deps:** T11

Tạo `VocabularyExport` class. Thêm nút "Export Excel" vào trang danh sách từ (T11). Export toàn bộ vocabulary của một set kèm đầy đủ các field. Dùng cùng package `maatwebsite/excel` với T18.

**Checklist:**
- [ ] Tạo `app/Exports/VocabularyExport.php` implements `FromCollection`, `WithHeadings`
- [ ] Export: id, word, pronunciation, meaning, description_en, example, collocation, related_words, note
- [ ] Thêm method `export()` vào `VocabularyIndex` component
- [ ] Download trả về file `{set-name}-vocabulary.xlsx`

---

### T20 — Progress Dashboard (Livewire)
**Assignee:** Dev 3 | **Ngày:** 8–9 | **Deps:** T16

Tạo `Dashboard/ProgressDashboard.php` hiển thị tổng quan tiến độ học: tổng số từ theo từng status (new/learning/review/mastered), streak hiện tại, số từ học hôm nay vs mục tiêu, tổng số từ trong tất cả sets. Cần T16 có dữ liệu thực sau khi học.

**Checklist:**
- [ ] `php artisan make:livewire Dashboard/ProgressDashboard`
- [ ] Stats cards: Total Words, Mastered, In Review, New
- [ ] Streak display với fire icon
- [ ] Today progress: X/Y từ (progress bar)
- [ ] List sets với % hoàn thành
- [ ] Route `/dashboard` (trang chính sau login)

---

### T21 — Activity Chart Component (Chart.js)
**Assignee:** Dev 3 | **Ngày:** 9 | **Deps:** T20

Tạo `Dashboard/ActivityChart.php` hiển thị: biểu đồ cột 30 ngày gần nhất (số từ học mỗi ngày), pie chart phân bổ status SRS. Dùng Chart.js qua CDN, khởi tạo bằng AlpineJS `x-init`. Data truyền từ Livewire component qua `@js()`.

**Checklist:**
- [ ] `php artisan make:livewire Dashboard/ActivityChart`
- [ ] Query `study_logs` group by DATE(studied_at), count, 30 ngày gần nhất
- [ ] Bar chart: ngày x-axis, số từ y-axis
- [ ] Pie/Doughnut chart: new/learning/review/mastered breakdown
- [ ] Nhúng Chart.js qua `<script src>` trong layout
- [ ] Livewire `$wire.on` refresh chart khi data thay đổi

---

### T22 — Streak Tracking System
**Assignee:** Dev 1 | **Ngày:** 9 | **Deps:** T16

Tạo logic cập nhật `streak_days` và `last_study_date` trên User sau mỗi phiên học. Rule: nếu `last_study_date = yesterday` → streak++; nếu `last_study_date = today` → không đổi; còn lại → reset về 1. Gắn vào event khi `LearningSession` hoàn thành (T16).

**Checklist:**
- [ ] Tạo method `updateStreak(User $user): void` trong service hoặc User model
- [ ] Logic ngày: dùng Carbon compare dates (không compare datetime)
- [ ] Gọi sau khi LearningSession kết thúc (ít nhất 1 từ đã được học)
- [ ] Hiển thị streak trên header (layout app.blade.php T02)
- [ ] Hiển thị streak trên màn hình kết quả phiên học (T16)

---

### T23 — Notification: Daily Reminder (Email)
**Assignee:** Dev 4 | **Ngày:** 8 | **Deps:** T05

Tạo `Notifications/DailyStudyReminder.php` và `Jobs/SendDailyReminderJob.php`. Schedule job chạy mỗi ngày 8h sáng, gửi email cho user nào có `last_study_date != today` (chưa học hôm nay). Cấu hình queue database driver.

**Checklist:**
- [ ] `php artisan make:notification DailyStudyReminder`
- [ ] `php artisan make:job SendDailyReminderJob`
- [ ] Email nội dung: lời nhắc học, số từ cần review hôm nay, link đến app
- [ ] `App\Console\Kernel` schedule: `->dailyAt('08:00')`
- [ ] `config/queue.php` QUEUE_CONNECTION=database
- [ ] `php artisan queue:table && php artisan migrate`
- [ ] Test bằng `php artisan queue:work` local

---

### T24 — Notification: Review Reminder
**Assignee:** Dev 4 | **Ngày:** 9 | **Deps:** T23

Tạo `Notifications/ReviewWordsReminder.php` và `Jobs/SendReviewReminderJob.php`. Gửi email khi user có từ quá hạn review (`next_review_at < now() - 24h`). Schedule chạy mỗi ngày 6h chiều. Phụ thuộc T23 vì dùng chung infrastructure Queue.

**Checklist:**
- [ ] `php artisan make:notification ReviewWordsReminder`
- [ ] `php artisan make:job SendReviewReminderJob`
- [ ] Email nội dung: số từ quá hạn, danh sách set có từ cần ôn
- [ ] Schedule `->dailyAt('18:00')`
- [ ] Không gửi nếu user đã học hôm nay (last_study_date = today)

---

### T25 — Public Vocabulary Sets (Browse & Clone)
**Assignee:** Dev 2 | **Ngày:** 10 | **Deps:** T10

Tạo trang "Khám phá" liệt kê tất cả set có `is_public = true`. Cho phép user clone set của người khác về tài khoản mình (deep copy: tạo set mới + copy toàn bộ vocabulary). Phụ thuộc T10 vì dùng chung VocabularySet model và UI patterns.

**Checklist:**
- [ ] Livewire component `Vocabulary/PublicSetBrowser` với search + filter tags
- [ ] Hiển thị: tên set, tác giả, số từ, tags
- [ ] Method `cloneSet(VocabularySet $set): void` — tạo VocabularySet mới + copy vocabularies
- [ ] Không thể clone set của chính mình
- [ ] Route `/explore`
- [ ] Link "Khám phá" trong sidebar

---

### T26 — Search Từ Vựng Global
**Assignee:** Dev 3 | **Ngày:** 10 | **Deps:** T11

Thêm thanh search trong header cho phép tìm kiếm từ vựng trong tất cả set của user (và public sets). Dùng Livewire component nhúng vào header layout, debounce 300ms. Kết quả hiển thị inline dropdown với tên từ, nghĩa, set chứa từ đó.

**Checklist:**
- [ ] Livewire component `GlobalSearch` nhúng vào `app.blade.php`
- [ ] Search query >= 2 ký tự mới bắt đầu query
- [ ] Debounce 300ms với `wire:model.live.debounce.300ms`
- [ ] Kết quả: top 10 matches, hiển thị word + meaning + set name
- [ ] Click kết quả → điều hướng đến set chứa từ đó
- [ ] Đóng dropdown khi click outside (AlpineJS)

---

### T27 — QC: Viết Test Cases & Test Sprint 1–2
**Assignee:** QC | **Ngày:** 8–9 | **Deps:** T09, T16

Viết test cases manual cho: đăng ký/đăng nhập, tạo vocabulary set, thêm từ, chạy một phiên học FlashCard đến hết. Dùng dữ liệu seeder từ T09. Report bugs vào GitHub Issues với label `bug`, `priority`. Cần T16 hoàn thành để có full user flow.

**Checklist:**
- [ ] Viết test plan document trong `docs/test-plan-sprint1-2.md`
- [ ] Test auth: register, login, logout, profile edit
- [ ] Test vocab: tạo set, thêm từ, sửa từ, xóa từ
- [ ] Test learning: init SRS, học flashcard, submit ratings, xem kết quả
- [ ] Test daily plan: hiển thị đúng số từ new + review
- [ ] Report bugs vào GitHub Issues với steps to reproduce

---

### T28 — QC: Test Sprint 3
**Assignee:** QC | **Ngày:** 11 | **Deps:** T18, T20, T23, T27

Test các feature của Sprint 3: import Excel (file hợp lệ/không hợp lệ), export, dashboard số liệu khớp thực tế, activity chart hiển thị đúng, email notification gửi đúng. Báo cáo bug vào GitHub Issues. Verify fixes từ T27.

**Checklist:**
- [ ] Test import: file hợp lệ, file thiếu cột bắt buộc, file rỗng
- [ ] Test export: download file, mở trong Excel verify nội dung
- [ ] Test dashboard: stats khớp với số từ thực tế đã học
- [ ] Test notification: verify email gửi qua mail log/mailtrap
- [ ] Test public browse: clone set, verify deep copy
- [ ] Re-test bugs từ T27 đã được fix

---

## SPRINT 4 — Polish & Deploy (Ngày 12–14)

---

### T29 — Responsive Design (Mobile/Tablet)
**Assignee:** Dev 3 | **Ngày:** 12 | **Deps:** T15, T20, T26

Rà soát và fix toàn bộ UI trên màn hình nhỏ (< 768px). Ưu tiên theo thứ tự: Flashcard (T15) → Daily Plan (T14) → Dashboard (T20) → Vocab list (T11) → Sidebar navigation. Dùng Tailwind responsive prefixes `sm:`, `md:`.

**Checklist:**
- [ ] Kiểm tra toàn bộ trang trên Chrome DevTools: 375px (mobile), 768px (tablet)
- [ ] Flashcard: card đủ lớn, nút rating dễ bấm trên mobile
- [ ] Sidebar: collapse thành hamburger menu trên mobile
- [ ] Tables (vocab list): scroll ngang hoặc chuyển thành cards
- [ ] Dashboard stats: 2 cột thay vì 4 trên mobile
- [ ] Charts (T21): responsive width

---

### T30 — Unit Tests: SpacedRepetitionService
**Assignee:** Dev 1 | **Ngày:** 12 | **Deps:** T12

Viết PHPUnit tests đầy đủ cho `SpacedRepetitionService`. Test tất cả 4 rating levels với nhiều input combinations. Verify constraints: EF không xuống dưới 1.3, interval tăng đúng, status chuyển đúng. Coverage mục tiêu > 90%.

**Checklist:**
- [ ] `php artisan make:test SpacedRepetitionServiceTest --unit`
- [ ] Test `calculate()` với rating=again: interval reset, status=learning
- [ ] Test `calculate()` với rating=hard: EF giảm, interval tăng chậm
- [ ] Test `calculate()` với rating=good: EF giữ, interval tăng bình thường
- [ ] Test `calculate()` với rating=easy: EF tăng, interval tăng nhanh
- [ ] Test EF không xuống dưới 1.3
- [ ] Test `getWordsForReview()` chỉ trả về từ đúng điều kiện
- [ ] `php artisan test --filter SpacedRepetitionServiceTest` — all pass

---

### T31 — Feature Tests: Livewire Components
**Assignee:** Dev 1 | **Ngày:** 12 | **Deps:** T11, T15

Viết Livewire feature tests dùng `Livewire::test()` cho các component quan trọng. Test validation, state changes, database updates sau interaction.

**Checklist:**
- [ ] Test `VocabularyForm`: submit valid data → record created; submit invalid → validation error
- [ ] Test `FlashCard`: `submitRating('good')` → srs_progress cập nhật, study_log tạo
- [ ] Test `DailyPlan`: hiển thị đúng count new/review words
- [ ] Test `VocabularySetForm`: tạo set → redirect đúng; xóa set → cascade xóa vocab
- [ ] `php artisan test` — all pass

---

### T32 — Performance: DB Indexing & Query Optimization
**Assignee:** Dev 1 | **Ngày:** 13 | **Deps:** T04, T12

Thêm DB indexes cho các query thường xuyên. Kiểm tra N+1 queries bằng Laravel Debugbar hoặc Telescope. Fix với eager loading.

**Checklist:**
- [ ] Cài `barryvdh/laravel-debugbar` (dev only)
- [ ] Index: `srs_progress(user_id, next_review_at)` — dùng trong Daily Plan
- [ ] Index: `study_logs(user_id, studied_at)` — dùng trong Dashboard/Charts
- [ ] Index: `vocabularies(set_id)` — dùng khi load từ trong set
- [ ] Fix eager loading: `with(['vocabularies', 'user'])` thay vì lazy load trong loop
- [ ] Verify: trang Dashboard load < 500ms với 1000 từ

---

### T33 — Bug Fix: Xử Lý Lỗi & Validation Edge Cases
**Assignee:** Dev 2 | **Ngày:** 13 | **Deps:** T27, T28

Fix toàn bộ bugs từ báo cáo QC (T27, T28). Ưu tiên: P1 blocking bugs trước, sau đó P2.

**Checklist:**
- [ ] Review tất cả GitHub Issues có label `bug`
- [ ] Fix P1 bugs (blocking user flow)
- [ ] Fix P2 bugs (wrong data, UI glitch)
- [ ] Edge case: user chưa có DailyGoal → DailyPlan không crash, dùng default
- [ ] Edge case: set rỗng (0 từ) → không hiển thị nút "Học"
- [ ] Edge case: import Excel với ký tự đặc biệt (UTF-8)
- [ ] Update GitHub Issues: close fixed, comment steps verified

---

### T34 — UI Polish: Toast Notifications & Loading States
**Assignee:** Dev 3 | **Ngày:** 13 | **Deps:** T10, T11, T15

Thêm toast notification khi: tạo/sửa/xóa thành công, import hoàn tất. Thêm loading spinner/skeleton cho các Livewire actions nặng. Đảm bảo UX nhất quán toàn app.

**Checklist:**
- [ ] Tạo toast component AlpineJS trong layout `app.blade.php`
- [ ] Livewire dispatch event `toast` với message + type (success/error/info)
- [ ] Loading spinner cho: import Excel, export, load charts
- [ ] Livewire `wire:loading` directive trên submit buttons
- [ ] Empty states: trang vocab set rỗng, không có từ nào cần học hôm nay
- [ ] Disable nút submit khi đang xử lý (prevent double submit)

---

### T35 — Cấu Hình Môi Trường Production
**Assignee:** Dev 1 | **Ngày:** 13 | **Deps:** T23

Tạo `.env.production` template, cấu hình tất cả production settings. Tạo checklist deploy.

**Checklist:**
- [ ] Tạo `.env.example` đầy đủ với tất cả keys cần thiết
- [ ] `APP_ENV=production`, `APP_DEBUG=false`
- [ ] `QUEUE_CONNECTION=database`
- [ ] Mail driver: SMTP hoặc Mailgun
- [ ] `SESSION_DRIVER=database` hoặc `redis`
- [ ] Tạo `docs/deployment-checklist.md`: danh sách lệnh cần chạy khi deploy
- [ ] Tạo `docs/env-setup.md`: hướng dẫn cài đặt từng biến môi trường

---

### T36 — Deploy lên Server
**Assignee:** Dev 1 | **Ngày:** 14 | **Deps:** T35, T32

Upload code lên VPS/shared hosting, chạy production setup, verify app hoạt động. Setup cron job cho Laravel Scheduler.

**Checklist:**
- [ ] Upload code qua git pull hoặc rsync
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] `php artisan migrate --force`
- [ ] `npm run build` (hoặc upload compiled assets)
- [ ] `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- [ ] Setup cron: `* * * * * php /path/to/artisan schedule:run`
- [ ] Setup queue worker: supervisor hoặc `php artisan queue:work --daemon`
- [ ] Verify: truy cập production URL, đăng nhập, học 1 từ thành công

---

### T37 — Setup CI/CD GitHub Actions
**Assignee:** Dev 1 | **Ngày:** 14 | **Deps:** T30, T31, T36

Tạo GitHub Actions workflow chạy tests tự động trên mỗi push/PR vào `main`. Đảm bảo team không merge code lỗi.

**Checklist:**
- [ ] Tạo `.github/workflows/ci.yml`
- [ ] Jobs: checkout, setup PHP 8.2, composer install, copy .env.testing, migrate testing DB, run tests
- [ ] Cache composer dependencies để tăng tốc
- [ ] Badge CI status trên README
- [ ] Tùy chọn: PHP CS Fixer lint check

---

### T38 — QC: Final E2E Testing
**Assignee:** QC | **Ngày:** 14 | **Deps:** T36

Test end-to-end toàn bộ user journey trên môi trường production. Verify trên cả mobile và desktop.

**Checklist:**
- [ ] User journey 1 (desktop): đăng ký → profile → tạo set → thêm 5 từ → học flashcard → xem dashboard
- [ ] User journey 2 (mobile): đăng nhập → import Excel → học → xem streak
- [ ] User journey 3: Google OAuth → browse public sets → clone set → học
- [ ] Verify email: đăng ký nhận welcome email, trigger review reminder
- [ ] Performance: trang dashboard load < 2s trên production
- [ ] Report: pass/fail per test case, sign-off hoặc list blocking issues

---

### T39 — Documentation: README & User Guide
**Assignee:** Dev 4 | **Ngày:** 14 | **Deps:** T36

Viết tài liệu kỹ thuật và hướng dẫn sử dụng cho dự án.

**Checklist:**
- [ ] Cập nhật `README.md`: mô tả dự án, tech stack, cài đặt local (step by step), screenshots
- [ ] Tạo `docs/user-guide.md`: hướng dẫn end-user sử dụng app (tạo set, import, học flashcard)
- [ ] Tạo `docs/api-architecture.md`: mô tả kiến trúc, flow diagram SRS
- [ ] Screenshots: chụp các trang chính, nhúng vào README

---

### T40 — Retrospective & Handoff
**Assignee:** Tất cả | **Ngày:** 14 | **Deps:** T38

Họp review sprint kết thúc dự án. Tổng kết, ghi nhận, bàn giao.

**Checklist:**
- [ ] Họp team review: what went well, what didn't, lessons learned
- [ ] Tạo `docs/technical-debt.md`: danh sách kỹ thuật nợ và tính năng chưa làm
- [ ] Backlog Sprint tiếp theo: mobile app, gamification (badges, leaderboard), AI suggest từ vựng
- [ ] Bàn giao: credentials server, .env production, domain/hosting info
- [ ] Tag git release `v1.0.0`

---

## Dependency Map

```
T01 ──► T02 (layout)
     ├─► T03 (users migration) ──► T04 (all tables) ──► T05 (models)
     └─► T06 (auth)

T05 + T06 ──► T07 (profile)
T06 ──────► T08 (google oauth)
T05 ──────► T09 (seeders)

T05 + T06 ──► T10 (set CRUD) ──► T11 (vocab CRUD) ──► T18, T19, T25
T05 ────────► T12 (SRS service) ──► T13 (init progress) ──► T14 (daily plan)
T11 + T12 ──► T15 (flashcard)
T14 + T15 ──► T16 (session) ──► T22 (streak) ──► T20 (dashboard) ──► T21 (charts)

T05 + T07 ──► T17 (daily goals)
T05 ────────► T23 (email reminder) ──► T24 (review reminder)
T11 ────────► T26 (global search)
T10 ────────► T25 (public sets)

T09 + T16 ──► T27 (QC sprint 1-2) ──► T28 (QC sprint 3) ──► T33 (bug fix)
T12 ────────► T30 (unit tests)
T11 + T15 ──► T31 (feature tests)
T04 + T12 ──► T32 (db optimization)

T15 + T20 + T26 ──► T29 (responsive)
T10 + T11 + T15 ──► T34 (UI polish)
T23 ────────────► T35 (prod config) ──► T36 (deploy) ──► T38 (E2E), T39 (docs)
T30 + T31 + T36 ──► T37 (CI/CD)
T38 ────────────► T40 (retrospective)
```

---

## Tổng Kết

| Thống kê | Số lượng |
|----------|----------|
| Tổng tasks | **40** |
| Sprint 1 (N1–3) | 9 tasks |
| Sprint 2 (N4–7) | 8 tasks |
| Sprint 3 (N8–11) | 11 tasks |
| Sprint 4 (N12–14) | 12 tasks |

| Assignee | Số tasks |
|----------|----------|
| Dev 1 | 14 |
| Dev 2 | 11 |
| Dev 3 | 10 |
| Dev 4 | 3 |
| QC | 3 |
| Tất cả | 1 |

**Tính năng mở rộng so với plan gốc (5 ngày → 14 ngày):**
- T08 Google OAuth, T09 Seeders/Factories
- T17 Daily Goals Settings riêng biệt
- T22 Streak Tracking System
- T25 Public Sets Browse & Clone
- T26 Global Search
- T30–T31 Unit + Feature Tests đầy đủ
- T32 DB Indexing & Performance
- T37 CI/CD GitHub Actions
- T39 Documentation, T40 Retrospective
