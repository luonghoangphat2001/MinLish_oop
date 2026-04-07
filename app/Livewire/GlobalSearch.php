<?php

namespace App\Livewire;

use App\Models\Vocabulary;
use App\Models\VocabularySet;
use Livewire\Component;
use Livewire\Attributes\On;

class GlobalSearch extends Component
{
    public string $query = '';
    public bool $showResults = false;
    public array $results = [];

    public function updatedQuery(): void
    {
        $this->debouncedSearch();
    }

    #[On('close-search')]
    public function closeSearch(): void
    {
        $this->showResults = false;
        $this->query = '';
        $this->results = [];
    }

    public function goToResult($vocabularyId): void
    {
        $vocabulary = Vocabulary::findOrFail($vocabularyId);
        $this->dispatch('navigate', url: route('vocabulary.words', $vocabulary->set));
        $this->closeSearch();
    }

    public function debouncedSearch()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->results = Vocabulary::where(function ($query) {
                $query->where('word', 'like', '%' . $this->query . '%')
                      ->orWhere('meaning', 'like', '%' . $this->query . '%');
            })
            ->with(['set.user:id,name'])
            ->whereHas('set.user', function ($q) {
                $q->where('id', auth()->id());
            })
            ->orWhereHas('set', function ($q) {
                $q->where('is_public', true);
            })
            ->limit(10)
            ->get()
            ->map(fn($v) => [
                'id' => $v->id,
                'word' => $v->word,
                'meaning' => $v->meaning,
                'set' => $v->set->name,
                'author' => $v->set->user?->name ?? 'Public',
                'url' => route('vocabulary.words', $v->set)
            ])
            ->toArray();

        $this->showResults = count($this->results) > 0;
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
