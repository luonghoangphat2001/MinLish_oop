<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_goals', function (Blueprint $table) {
            $table->integer('daily_quiz_words_per_day')->default(25)->after('review_words_per_day');
        });
    }

    public function down(): void
    {
        Schema::table('daily_goals', function (Blueprint $table) {
            $table->dropColumn('daily_quiz_words_per_day');
        });
    }
};
