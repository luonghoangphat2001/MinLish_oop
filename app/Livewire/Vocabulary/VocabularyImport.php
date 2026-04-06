<?php

namespace App\Livewire\Vocabulary;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\VocabularyImport;
use Maatwebsite\Excel\Facades\Excel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Storage;

class VocabularyImport extends Component
{
    use WithFileUploads, LivewireAlert;

    public $setId;
    public $file;
    public $isUploading = false;
    public $uploadProgress = 0;
    public $importedCount = 0;
    public $errors = [];

    public function mount($setId)
    {
        $this->setId = $setId;
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048', // 2MB max
        ]);
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $this->isUploading = true;
        $this->uploadProgress = 10;

        try {
            Excel::import(new VocabularyImport($this->setId), $this->file);

            $this->importedCount = Vocabulary::where('set_id', $this->setId)->count();
            $this->alert('success', 'Import thành công! Đã thêm ' . $this->importedCount . ' từ vựng.');

            $this->dispatch('import-completed');
            $this->reset(['file']);
        } catch (\Exception $e) {
            $this->errors = [$e->getMessage()];
            $this->alert('error', 'Lỗi import: ' . $e->getMessage());
        } finally {
            $this->isUploading = false;
            $this->uploadProgress = 100;
        }
    }

    public function downloadTemplate()
    {
        $templatePath = storage_path('app/public/templates/vocabulary-template.xlsx');
        return response()->download($templatePath, 'vocabulary-template.xlsx');
    }

    public function render()
    {
        return view('livewire.vocabulary.vocabulary-import');
    }
}

