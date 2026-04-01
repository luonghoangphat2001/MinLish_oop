<?php

namespace App\Http\Livewire\Vocabulary;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\VocabularySet;

class VocabularySetIndex extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteSet(int $setId): void
    {
        $set = VocabularySet::where('user_id', Auth::id())->findOrFail($setId);
        $set->delete();

        session()->flash('message', 'Đã xoá bộ từ!');
    }

    public function render()
    {
        $sets = VocabularySet::where('user_id', Auth::id())
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->withCount('vocabularies')
            ->latest()
            ->paginate(12);

        return view('livewire.vocabulary.set-index', compact('sets'));
    }
}
