<?php

namespace App\Livewire\Vocabulary;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VocabularySet;
use Livewire\Attributes\On;

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
}
