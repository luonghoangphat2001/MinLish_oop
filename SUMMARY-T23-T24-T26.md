# Summary & Code: T23, T24, T26 (BLACKBOXAI Implemented)

## T23: Daily Reminder (Day 8, Sprint 3)
**Desc:** Daily email reminder for users who haven't studied today.
**Files:**
- `app/Jobs/SendDailyReminderJob.php`: Query + notify
- `app/Notifications/DailyStudyReminder.php`: Mail template
**Schedule:** `->dailyAt('08:00')`
**Code Snippet (Job handle):**
```php
User::whereDate('last_study_date', '!=', today())->chunk(100, fn($users) => $users->each(fn($u) => $u->notify(new DailyStudyReminder)));
```

## T24: Review Reminder (Day 9, Sprint 3, Deps T23)
**Desc:** Email for overdue SRS words (`next_review_at < now()-24h`), skip if studied today.
**Files:**
- `app/Jobs/SendReviewReminderJob.php`: Chunk overdue + not-studied
- `app/Notifications/ReviewWordsReminder.php`: Cute/professional mail
**Schedule:** `->dailyAt('18:00')`
**Code Snippet (Query):**
```php
User::whereHas('srsProgress', fn($q) => $q->where('next_review_at', '<', now()->subDay()))
    ->whereDoesntHave('studyLogs', fn($q) => $q->whereDate('studied_at', today()))
    ->chunk(100, ...);
```
**Mail Tone:** Duolingo-cute + Ebbinghaus scholarly (refined 3x per feedback)

## T26: Global Search (Day 10, Sprint 3, Deps T11)
**Desc:** Header search bar for vocab across user sets, debounce, dropdown results.
**Files:**
- `app/Livewire/GlobalSearch.php`: Query + selectResult()
- `resources/views/livewire/global-search.blade.php`: Responsive dropdown
**Integration:** Header in `layouts/app.blade.php`
**Code Snippet (Search):**
```php
Vocabulary::join('vocabulary_sets', ...)
    ->where('word/meaning', 'like', $query)
    ->where('sets.user_id', auth()->id())
    ->limit(10)
```
**Features:** Min 2 chars, debounce 300ms, click → set page

**Stability:** No conflicts, main branch, chunked queries, user-scoped.

**Deploy:** `npm run build && php artisan serve` → test search/notifications! 🚀
