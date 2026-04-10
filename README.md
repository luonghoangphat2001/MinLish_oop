# MinLish — Ứng Dụng Học Từ Vựng Tiếng Anh

Ứng dụng web học từ vựng tiếng Anh với thuật toán SRS (SM-2), Flashcard, và theo dõi tiến độ học.

**Tech Stack:** PHP 8.2+, Laravel 11, Livewire 3, Tailwind CSS 3, AlpineJS 3, SQLite

---

## Yêu Cầu Hệ Thống

- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x + npm
- SQLite (có sẵn trong PHP, không cần cài thêm)

---

## Hướng Dẫn Cài Đặt

### 1. Clone project

```bash
git clone https://github.com/luonghoangphat2001/MinLish_oop.git
cd MinLish_oop
```

### 2. Cài dependencies

```bash
composer install
npm install
```

### 3. Cấu hình môi trường

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Kiểm tra cấu hình Database trong `.env`

Mặc định dùng **SQLite** — không cần cài MySQL:

```env
DB_CONNECTION=sqlite
```

File DB sẽ tự tạo tại `database/database.sqlite`.

### 5. Chạy migrations

```bash
php artisan migrate
```

Migrations sẽ tạo các bảng:

- `users` — user account + trình độ, mục tiêu, streak
- `vocabulary_sets` — bộ từ vựng
- `vocabularies` — từ vựng trong bộ
- `srs_progress` — tiến độ SRS mỗi từ/user (SM-2)
- `study_logs` — lịch sử học
- `daily_goals` — mục tiêu học hàng ngày

### 6. Build assets

```bash
npm run build
```

### 7. Chạy ứng dụng

```bash
php artisan serve
```

Truy cập: http://localhost:8000

## Luồng Đăng Ký / Đăng Nhập

```
/register   →  Tạo tài khoản mới
/login      →  Đăng nhập
/dashboard  →  Trang chính (sau login)
/profile    →  Cập nhật thông tin, mục tiêu học
/logout     →  Đăng xuất (POST)
```

---

## Cấu Trúc Thư Mục Quan Trọng

```
app/
├── Http/Livewire/
│   └── Auth/ProfileEdit.php       # Trang hồ sơ người dùng
├── Models/
│   ├── User.php
│   ├── VocabularySet.php
│   ├── Vocabulary.php
│   ├── SrsProgress.php
│   ├── StudyLog.php
│   └── DailyGoal.php
└── Services/
    └── SpacedRepetitionService.php  # Thuật toán SM-2

database/migrations/               # Tất cả DB schema
resources/views/
├── layouts/
│   ├── app.blade.php              # Layout chính (có sidebar)
│   └── guest.blade.php            # Layout auth pages
└── livewire/auth/
    └── profile-edit.blade.php
```

---

## Chạy Tests

```bash
php artisan test
# hoặc test riêng SM-2 algorithm:
php artisan test tests/Unit/SpacedRepetitionServiceTest.php
```

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
