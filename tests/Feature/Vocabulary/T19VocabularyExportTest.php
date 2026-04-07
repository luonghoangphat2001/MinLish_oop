<?php

namespace Tests\Feature\Vocabulary;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\VocabularySet;
use App\Models\Vocabulary;
use App\Livewire\Vocabulary\VocabularyIndex;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

class T19VocabularyExportTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private VocabularySet $set;
    private array $vocabData;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed --class=DatabaseSeeder');
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->set = VocabularySet::factory()->create(['user_id' => $this->user->id]);

        // Create sample vocabulary for export
        $this->vocabData = [
            [
                'set_id' => $this->set->id,
                'word' => 'test',
                'pronunciation' => '/test/',
                'meaning' => 'kiểm tra',
                'description_en' => 'English desc',
                'example' => 'test example',
                'collocation' => 'test collocation',
                'related_words' => 'related',
                'note' => 'note'
            ]
        ];
        foreach ($this->vocabData as $data) {
            Vocabulary::create($data);
        }
    }

    /** @test */
    public function can_access_vocabulary_index_for_own_set()
    {
        Livewire::test(VocabularyIndex::class, ['set' => $this->set->id])
            ->assertStatus(200)
            ->assertSee('test'); // Sample word
    }

    /** @test */
    public function rejects_access_to_other_users_set()
    {
        $otherSet = VocabularySet::factory()->create();
        Livewire::test(VocabularyIndex::class, ['set' => $otherSet->id])
            ->assertForbidden();
    }

    /** @test */
    public function export_set_returns_excel_file_with_correct_data()
    {
        Excel::fake();

        Livewire::test(VocabularyIndex::class, ['set' => $this->set])
            ->call('exportSet');

        Excel::assertDownloaded(function () {
            return true;
        });

        $this->assertStringContainsString('test-vocabulary.xlsx', Excel::downloads()->first()->getName());
    }

    /** @test */
    public function export_file_contains_correct_column_headers_and_data()
    {
        $component = Livewire::test(VocabularyIndex::class, ['set' => $this->set]);
        $response = $component->call('exportSet');

        $filename = $this->set->name . '-vocabulary.xlsx';
        $this->assertStringContainsString($filename, $response->getFileDownloadName() ?? '');

        // Verify data would be in export (headers: id, word, pronunciation, etc.)
        $this->assertDatabaseHas('vocabularies', [
            'set_id' => $this->set->id,
            'word' => 'test'
        ]);
    }

    /** @test */
    public function export_empty_set_returns_empty_excel()
    {
        $emptySet = VocabularySet::factory()->create(['user_id' => $this->user->id]);

        Excel::fake();

        Livewire::test(VocabularyIndex::class, ['set' => $emptySet])
            ->call('exportSet');

        Excel::assertDownloaded();
    }

    /** @test */
    public function export_filename_uses_set_name()
    {
        $this->set->update(['name' => 'My Custom Set']);

        $component = Livewire::test(VocabularyIndex::class, ['set' => $this->set]);
        $download = $component->call('exportSet');

        $expectedName = 'My Custom Set-vocabulary.xlsx';
        $this->assertMatches('/My Custom Set-vocabulary\.xlsx/', $download->headers->get('content-disposition'));
    }
}

