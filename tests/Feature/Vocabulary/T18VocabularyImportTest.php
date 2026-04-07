<?php

namespace Tests\Feature\Vocabulary;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\VocabularySet;
use App\Livewire\Vocabulary\VocabularyImporter;
use App\Imports\VocabularyImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class T18VocabularyImportTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private VocabularySet $set;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed --class=DatabaseSeeder');
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->set = VocabularySet::factory()->create(['user_id' => $this->user->id]);
    }

    /** @test */
    public function mounts_with_set_id_and_renders_successfully()
    {
        Livewire::test(VocabularyImporter::class, ['setId' => $this->set->id])
            ->assertStatus(200)
            ->assertSee('Import từ vựng từ Excel/CSV');
    }

    /** @test */
    public function validates_file_upload_correctly()
    {
        Livewire::test(VocabularyImporter::class, ['setId' => $this->set->id])
            ->set('file', null)
            ->call('import')
            ->assertHasErrors(['file' => 'required']);

        // Valid file
        $validFile = UploadedFile::fake()->create('test.csv', 1000, 'text/csv');
        Livewire::test(VocabularyImporter::class, ['setId' => $this->set->id])
            ->set('file', $validFile)
            ->call('updatedFile')
            ->assertHasNoErrors();
    }

    /** @test */
    public function import_processes_valid_excel_file_successfully()
    {
        // Mock Excel import
        Excel::fake();

        $validFile = UploadedFile::fake()->create('vocab.xlsx', 1000, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        Livewire::test(VocabularyImporter::class, ['setId' => $this->set->id])
            ->set('file', $validFile)
            ->call('import');

// Excel::assertImported(VocabularyImport::class, 1);

        $this->assertDatabaseHas('vocabularies', ['set_id' => $this->set->id]);
    }

    /** @test */
    public function handles_validation_errors_from_excel_import()
    {
        Excel::fake();

        $invalidFile = UploadedFile::fake()->create('invalid.xlsx', 1000, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        Livewire::test(VocabularyImporter::class, ['setId' => $this->set->id])
            ->set('file', $invalidFile)
            ->call('import')
            ->assertSessionHas('error');
    }

    /** @test */
    public function download_template_returns_correct_file()
    {
        // Create mock template
        Storage::disk('public')->put('templates/vocabulary-template.csv', 'word,pronunciation,meaning');

        Livewire::test(VocabularyImporter::class, ['setId' => $this->set->id])
            ->call('downloadTemplate')
            ->assertInstanceOf(BinaryFileResponse::class);
    }

    /** @test */
    public function dispatches_import_completed_event_after_success()
    {
        Excel::fake();
        $validFile = UploadedFile::fake()->create('test.csv', 1000, 'text/csv');

        Livewire::test(VocabularyImporter::class, ['setId' => $this->set->id])
            ->set('file', $validFile)
            ->call('import')
            ->assertDispatched('import-completed');
    }

    /** @test */
    public function rejects_import_for_other_users_set()
    {
        $otherSet = VocabularySet::factory()->create();

        Livewire::test(VocabularyImporter::class, ['setId' => $otherSet->id])
            ->assertForbidden();
    }

    /** @test */
    public function handles_large_files_within_limit_2mb()
    {
        $largeFile = UploadedFile::fake()->create('large.csv', 1900 * 1024, 'text/csv'); // <2MB

        Livewire::test(VocabularyImporter::class, ['setId' => $this->set->id])
            ->set('file', $largeFile)
            ->call('updatedFile')
            ->assertHasNoErrors();
    }

    /** @test */
    public function rejects_files_over_2mb_limit()
    {
        $oversizeFile = UploadedFile::fake()->create('huge.csv', 3000 * 1024, 'text/csv'); // >2MB

        Livewire::test(VocabularyImporter::class, ['setId' => $this->set->id])
            ->set('file', $oversizeFile)
            ->call('updatedFile')
            ->assertHasErrors(['file' => 'max']);
    }
}

