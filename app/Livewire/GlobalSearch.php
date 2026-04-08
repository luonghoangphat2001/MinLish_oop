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
        if (trim($this->query) === '') {
            $this->results = [];
            return;
        }

        $this->results = Vocabulary::where('word', 'like', '%' . $this->query . '%')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'word' => $item->word,
                    'meaning' => $item->meaning,
                ];
            });
    }

    public function closeSearch()
    {
        $this->showResults = false;
        $this->query = '';
        $this->results = [];
    }

    public function goToResult($id)
    {
        return redirect()->route('vocabulary.show', $id);
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
