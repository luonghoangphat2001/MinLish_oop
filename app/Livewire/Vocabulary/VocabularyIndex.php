<?php

namespace App\Livewire\Vocabulary;

use App\Models\Vocabulary;
use App\Models\VocabularySet;
use Livewire\Component;
use Livewire\WithPagination;

class VocabularyIndex extends Component
{
    use WithPagination;

    public VocabularySet $set;
    public ?int $editingId = null;
    public string $search = '';
    public string $word = '';
    public string $pronunciation = '';
    public string $meaning = '';
    public string $description_en = '';
    public string $example = '';
    public string $collocation = '';
    public string $related_words = '';
    public string $note = '';

    protected array $rules = [
        'word' => 'required|string|max:255',
        'meaning' => 'required|string|max:1000',
        'pronunciation' => 'nullable|string|max:255',
        'description_en' => 'nullable|string|max:2000',
        'example' => 'nullable|string|max:2000',
        'collocation' => 'nullable|string|max:1000',
        'related_words' => 'nullable|string|max:1000',
        'note' => 'nullable|string|max:2000',
    ];

<<<<<<< HEAD
=======
    public $importFile;

>>>>>>> origin/main
    public function mount(VocabularySet $set): void
    {
        abort_unless($set->user_id === auth()->id(), 403);
        $this->set = $set;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function saveWord(): void
    {
        $this->validate();

        $payload = [
            'set_id' => $this->set->id,
            'word' => trim($this->word),
            'pronunciation' => $this->nullable($this->pronunciation),
            'meaning' => trim($this->meaning),
            'description_en' => $this->nullable($this->description_en),
            'example' => $this->nullable($this->example),
            'collocation' => $this->nullable($this->collocation),
            'related_words' => $this->nullable($this->related_words),
            'note' => $this->nullable($this->note),
        ];

        if ($this->editingId) {
            $word = Vocabulary::where('set_id', $this->set->id)->findOrFail($this->editingId);
            $word->update($payload);
            session()->flash('message', 'Da cap nhat tu thanh cong.');
        } else {
            Vocabulary::create($payload);
            session()->flash('message', 'Da them tu moi vao bo.');
        }

        $this->resetForm();
    }

    public function editWord(int $wordId): void
    {
        $word = Vocabulary::where('set_id', $this->set->id)->findOrFail($wordId);

        $this->editingId = $word->id;
        $this->word = $word->word;
        $this->pronunciation = $word->pronunciation ?? '';
        $this->meaning = $word->meaning;
        $this->description_en = $word->description_en ?? '';
        $this->example = $word->example ?? '';
        $this->collocation = $word->collocation ?? '';
        $this->related_words = $word->related_words ?? '';
        $this->note = $word->note ?? '';
    }

    public function deleteWord(int $wordId): void
    {
        $word = Vocabulary::where('set_id', $this->set->id)->findOrFail($wordId);
        $word->delete();

        if ($this->editingId === $wordId) {
            $this->resetForm();
        }

        session()->flash('message', 'Da xoa tu khoi bo.');
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

<<<<<<< HEAD
=======
    public function updatedImportFile()
    {
        $this->import();
    }

    public function import()
    {
        if (!$this->importFile) return;

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\VocabularyImport($this->set->id),
                $this->importFile
            );

            session()->flash('message', 'Import thành công!');
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Đã import thành công!']);
            $this->importFile = null;
        } catch (\Exception $e) {
            session()->flash('error', 'Import thất bại: ' . $e->getMessage());
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Import thất bại!']);
        }
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\VocabularyExport($this->set->id),
            $this->set->name . '-vocabulary.xlsx'
        );
    }

    public function downloadTemplate()
    {
        $template = new \App\Exports\VocabularyExport(0); // Dummy set_id
        $headings = $template->headings();

        return response()->streamDownload(function () use ($headings) {
            $handle = fopen('php://output', 'w+');
            fputcsv($handle, $headings);
            fclose($handle);
        }, 'vocabulary-template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

>>>>>>> origin/main
    public function render()
    {
        $words = Vocabulary::where('set_id', $this->set->id)
            ->with(['srsProgress' => function ($query) {
                $query->where('user_id', auth()->id())
                    ->select('id', 'vocabulary_id', 'status');
            }])
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('word', 'like', '%' . $this->search . '%')
                        ->orWhere('meaning', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(20);

        return view('livewire.vocabulary.vocabulary-index', [
            'words' => $words,
        ]);
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->word = '';
        $this->pronunciation = '';
        $this->meaning = '';
        $this->description_en = '';
        $this->example = '';
        $this->collocation = '';
        $this->related_words = '';
        $this->note = '';
        $this->resetValidation();
    }

    private function nullable(string $value): ?string
    {
        $trimmed = trim($value);
        return $trimmed === '' ? null : $trimmed;
    }
}
