<?php

namespace App\Livewire\Vocabulary;

use App\Models\VocabularySet;
use App\Models\User;
use App\Services\StarterVocabularyService;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class VocabularySetIndex extends Component
{
    use WithPagination;

    public function paginationView()
    {
        return 'vendor.pagination.minlish-vibe';
    }

    #[Url]
    public $search = '';

    #[Url]
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
        /** @var User $user */
        $user = request()->user();

        $sets = $user->vocabularySets()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->tagFilter, function ($query) {
                $query->where('tags', 'like', '%' . $this->tagFilter . '%');
            })
            ->withCount('vocabularies')
            ->latest()
            ->paginate(6);

        return view('livewire.vocabulary.vocabulary-set-index', [
            'sets' => $sets,
        ]);
    }

    public function deleteSet($id)
    {
        /** @var User $user */
        $user = request()->user();

        $set = $user->vocabularySets()->findOrFail($id);
        $set->delete();
        $this->resetPage();

        session()->flash('message', 'Đã xoá bộ từ vựng thành công.');
    }

    public function createStarterSets(StarterVocabularyService $starterVocabularyService): void
    {
        /** @var User $user */
        $user = request()->user();

        if ($user->vocabularySets()->exists()) {
            session()->flash('message', 'Tài khoản đã có bộ từ. Bạn có thể tạo bộ mới thủ công.');
            return;
        }

        $starterVocabularyService->seedDefaultForUser($user);

        session()->flash('message', 'Đã tạo 2 bộ mặc định Learning và Working.');
    }
}