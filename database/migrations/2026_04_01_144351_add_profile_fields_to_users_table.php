<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('email');
            $table->enum('level', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->default('A1')->after('google_id');
            $table->string('goal')->nullable()->after('level');
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
