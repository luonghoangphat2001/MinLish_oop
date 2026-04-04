<?php

namespace App\Livewire\Vocabulary;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vocabulary;
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

    public function createStarterSets(): void
    {
        $user = auth()->user();

        if ($user->vocabularySets()->exists()) {
            session()->flash('message', 'Tai khoan da co bo tu. Ban co the tao bo moi thu cong.');
            return;
        }

        $starterSets = [
            [
                'name' => 'IELTS Speaking Basics',
                'description' => 'Cum tu va tu vung nen tang cho speaking.',
                'tags' => ['ielts', 'speaking', 'basic'],
                'words' => [
                    ['word' => 'coherent', 'meaning' => 'mach lac', 'example' => 'Your answer should be coherent and clear.'],
                    ['word' => 'hesitate', 'meaning' => 'ngap ngung', 'example' => 'I hesitate when I cannot find the right word.'],
                    ['word' => 'confident', 'meaning' => 'tu tin', 'example' => 'She speaks English in a confident way.'],
                    ['word' => 'perspective', 'meaning' => 'goc nhin', 'example' => 'From my perspective, online learning is convenient.'],
                    ['word' => 'beneficial', 'meaning' => 'co loi', 'example' => 'Reading daily is beneficial for vocabulary growth.'],
                ],
            ],
            [
                'name' => 'Workplace Communication',
                'description' => 'Tu vung giao tiep co ban noi cong so.',
                'tags' => ['business', 'work', 'communication'],
                'words' => [
                    ['word' => 'deadline', 'meaning' => 'han chot', 'example' => 'We need to finish this task before the deadline.'],
                    ['word' => 'follow up', 'meaning' => 'theo doi lai', 'example' => 'I will follow up with the client tomorrow.'],
                    ['word' => 'agenda', 'meaning' => 'chuong trinh hop', 'example' => 'Please check the meeting agenda in advance.'],
                    ['word' => 'negotiate', 'meaning' => 'dam phan', 'example' => 'They negotiate the contract terms carefully.'],
                    ['word' => 'collaborate', 'meaning' => 'hop tac', 'example' => 'Our teams collaborate on this project.'],
                ],
            ],
        ];

        foreach ($starterSets as $starterSet) {
            $set = VocabularySet::create([
                'user_id' => $user->id,
                'name' => $starterSet['name'],
                'description' => $starterSet['description'],
                'tags' => $starterSet['tags'],
                'is_public' => false,
            ]);

            foreach ($starterSet['words'] as $word) {
                Vocabulary::create([
                    'set_id' => $set->id,
                    'word' => $word['word'],
                    'meaning' => $word['meaning'],
                    'example' => $word['example'],
                ]);
            }
        }

        session()->flash('message', 'Da tao 2 bo tu mau de ban hoc thu ngay.');
    }
}
