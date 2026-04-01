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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabularies');
    }
};
