<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vocabulary;
use Livewire\Attributes\On;

class GlobalSearch extends Component
{
    public string $search = '';
    public array $results = [];
    public bool $showResults = false;

    public function updatedSearch()
    {
        $this->showResults = strlen($this->search) >= 2;

        if ($this->showResults) {
            $this->results = Vocabulary::with('set')
                ->where('word', 'like', '%' . $this->search . '%')
                ->orWhere('meaning', 'like', '%' . $this->search . '%')
                ->limit(10)
                ->get()
                ->map(fn($v) => [
                    'word' => $v->word,
                    'meaning' => $v->meaning,
                    'set' => $v->set->name,
                    'url' => route('vocabulary.set.words', $v->set_id)
                ])->toArray();
        } else {
            $this->results = [];
        }
    }

    #[On('close-search')]
    public function closeDropdown()
    {
        $this->showResults = false;
        $this->search = '';
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}

