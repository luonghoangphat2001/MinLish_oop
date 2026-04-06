<?php

namespace App\Livewire;

use App\Models\Vocabulary;
use App\Models\VocabularySet;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $query = '';
    public array $results = [];

    protected $listeners = [];

    public function updatedQuery(): void
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        $this->search();
    }

    /**
     * T26 - Ghi chú Lead: Core search logic global vocab.
     *
     * Query: User vocab (word OR meaning LIKE query)
     * Scope: auth()->id() sets only
     * Perf: Join + limit 10 + eager
     * Min 2 chars + debounce.300ms (wire)
     */
    public function search(): void
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        $this->results = Vocabulary::query()
            ->join('vocabulary_sets', 'vocabularies.set_id', '=', 'vocabulary_sets.id')
            ->where(function ($q) {
                $q->where('vocabularies.word', 'like', '%' . $this->query . '%')
                  ->orWhere('vocabularies.meaning', 'like', '%' . $this->query . '%');
            })
            ->where('vocabulary_sets.user_id', auth()->id()) // User sets only
            ->select('vocabularies.*', 'vocabulary_sets.name as set_name', 'vocabulary_sets.id as set_id')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function selectResult($index)
    {
        $result = $this->results[$index];
        $this->query = $result['word'];
        $this->dispatch('search-selected', $result);
        $this->results = [];
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}

