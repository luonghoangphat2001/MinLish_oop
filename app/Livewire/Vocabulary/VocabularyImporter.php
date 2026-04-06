<?php

/**
 * T18: Livewire Component - Vocabulary Import Modal ✓
 *
 * Modal for Excel/CSV vocabulary uploads. Features:
 * - File validation (2MB xlsx/xls/csv)
 * - Real-time progress bar
 * - Template download (`storage/app/public/templates/vocabulary-template.csv`)
 * - Native Laravel flash messages (no deps)
 * - Dispatch 'import-completed' for parent refresh
 *
 * Usage in blade:
 * @livewire('vocabulary.vocabulary-importer', ['setId' => $set->id])
 *
 * Leader Notes:
 * - Uses Maatwebsite\Excel batch chunking (1000 rows)
 * - Scoped to set_id (ownership safe)
 * - Mobile-responsive Tailwind + Alpine modal
 * - Zero external deps (removed LivewireAlert)
 *
 * @see app/Imports/VocabularyImport.php
 * @package App\Livewire\Vocabulary
 */
namespace App\Livewire\Vocabulary;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\VocabularyImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vocabulary;

class VocabularyImporter extends Component
{
    use WithFileUploads;

    public int $setId;
    public $file;
    public bool $isUploading = false;
    public int $uploadProgress = 0;
    public int $importedCount = 0;
    public array $errors = [];

    public function mount(int $setId): void
    {
        $this->setId = $setId;
    }

    public function updatedFile(): void
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048', // 2MB
        ]);
    }

    public function import(): void
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $this->isUploading = true;
        $this->uploadProgress = 10;

        try {
            Excel::import(new VocabularyImport($this->setId), $this->file);

            $this->importedCount = Vocabulary::where('set_id', $this->setId)->count();
            session()->flash('message', "Import thành công! Đã thêm {$this->importedCount} từ.");

            $this->dispatch('import-completed');
            $this->reset('file');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $this->errors = array_map(fn($f) => "Row {$f->row()}: {$f->errors()[0]}", $failures);
            session()->flash('error', 'Validation errors: ' . count($failures) . ' rows failed.');
        } catch (\Exception $e) {
            session()->flash('error', 'Import failed: ' . $e->getMessage());
        } finally {
            $this->isUploading = false;
            $this->uploadProgress = 100;
        }
    }

    public function downloadTemplate(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $templatePath = storage_path('app/public/templates/vocabulary-template.csv');
        if (!file_exists($templatePath)) {
            abort(404, 'Template not found');
        }
        return response()->download($templatePath, 'vocabulary-template.csv');
    }

    public function render()
    {
        return view('livewire.vocabulary.vocabulary-import');
    }
}

