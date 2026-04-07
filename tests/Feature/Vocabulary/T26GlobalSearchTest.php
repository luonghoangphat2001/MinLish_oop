<?php

namespace Tests\Feature\Vocabulary;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\GlobalSearch;
use App\Models\Vocabulary;
use App\Models\VocabularySet;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class T26GlobalSearchTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed --class=DatabaseSeeder');
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function renders_search_component()
    {
        Livewire::test(GlobalSearch::class)
            ->assertStatus(200);
    }

    /** @test */
    public function does_not_search_with_less_than_2_characters()
    {
        Livewire::test(GlobalSearch::class)
            ->set('search', 'a')
            ->assertSet('results', []);
    }

    /** @test */
    public function searches_vocabulary_with_2_plus_characters_debounced()
    {
        Vocabulary::factory()->create(['word' => 'apple']);
        Vocabulary::factory()->create(['word' => 'banana']);

        Livewire::test(GlobalSearch::class)
            ->set('search', 'app')
            ->assertSee('apple')
            ->assertDontSee('banana');
    }

    /** @test */
    public function limits_results_to_top_10()
    {
        Vocabulary::factory()->count(15)->create(['word' => 'test word']);

        Livewire::test(GlobalSearch::class)
            ->set('search', 'test')
            ->assertSee('test word', false) // Should see first 10
            ->assertCount(10, $this->livewire->results ?? []);
    }

    /** @test */
    public function shows_results_with_word_meaning_and_set()
    {
        $set = VocabularySet::factory()->create();
        $vocab = Vocabulary::factory()->create([
            'set_id' => $set->id,
            'word' => 'searchtest',
            'meaning' => 'kết quả tìm kiếm'
        ]);

        Livewire::test(GlobalSearch::class)
            ->set('search', 'sear')
            ->assertSee('searchtest')
            ->assertSee('kết quả tìm kiếm')
            ->assertSee($set->name);
    }

    /** @test */
    public function closes_dropdown_when_clicking_outside()
    {
        // Test AlpineJS interaction
        Livewire::test(GlobalSearch::class)
            ->set('search', 'test')
            ->call('closeDropdown')
            ->assertSet('showResults', false);
    }
}

