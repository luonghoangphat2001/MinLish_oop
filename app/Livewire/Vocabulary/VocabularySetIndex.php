<?php

namespace App\Livewire\Vocabulary;

use App\Models\VocabularySet;
use App\Services\StarterVocabularyService;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class VocabularySetIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $tagFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTagFilter()
    {
        $this->resetPage();
    }

    #[On('set-saved')]
    public function render()
    {
        $sets = auth()->user()->vocabularySets()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->tagFilter, function ($query) {
                $query->where('tags', 'like', '%' . $this->tagFilter . '%');
            })
            ->withCount('vocabularies')
            ->latest()
            ->paginate(10);

        return view('livewire.vocabulary.vocabulary-set-index', [
            'sets' => $sets,
        ]);
    }

    public function deleteSet($id)
    {
        $set = auth()->user()->vocabularySets()->findOrFail($id);
        $set->delete();
    }

    public function createStarterSets(StarterVocabularyService $starterVocabularyService): void
    {
        $user = auth()->user();

        if ($user->vocabularySets()->exists()) {
            session()->flash('message', 'Tài khoản đã có bộ từ. Bạn có thể tạo bộ mới thủ công.');
            return;
        }

        $starterVocabularyService->seedDefaultForUser($user);

        session()->flash('message', 'Đã tạo 2 bộ mặc định Learning và Working.');
    }
}
