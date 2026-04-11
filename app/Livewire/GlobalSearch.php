<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vocabulary;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];
    public $showResults = false;

    public function updatedQuery()
    {
        $search = trim($this->query);

        if ($search === '') {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->results = Vocabulary::where('word', 'like', "%{$search}%")
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'word' => $item->word,
                    'meaning' => $item->meaning,
                ];
            });

        $this->showResults = true;
    }

    public function closeSearch()
    {
        $this->showResults = false;
        $this->query = '';
        $this->results = [];
    }

   public function goToResult($id)
    {
        $vocab = Vocabulary::findOrFail($id);

        $this->closeSearch();

        return redirect()->route('vocabulary.words', [
            'set' => $vocab->set_id,
            'search' => $vocab->word,
        ]);
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
