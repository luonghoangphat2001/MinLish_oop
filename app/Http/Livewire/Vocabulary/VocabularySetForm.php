<?php

namespace App\Http\Livewire\Vocabulary;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\VocabularySet;

class VocabularySetForm extends Component
{
    public ?int $setId = null;
    public string $name        = '';
    public string $description = '';
    public string $tagsInput   = '';
    public bool $is_public     = false;

    protected array $rules = [
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'tagsInput'   => 'nullable|string',
        'is_public'   => 'boolean',
    ];

    public function mount(?int $setId = null): void
    {
        if ($setId) {
            $set = VocabularySet::where('user_id', Auth::id())->findOrFail($setId);
            $this->setId       = $set->id;
            $this->name        = $set->name;
            $this->description = $set->description ?? '';
            $this->tagsInput   = implode(', ', $set->tags ?? []);
            $this->is_public   = $set->is_public;
        }
    }

    public function save(): void
    {
        $this->validate();

        $tags = array_filter(array_map('trim', explode(',', $this->tagsInput)));

        $data = [
            'user_id'     => Auth::id(),
            'name'        => $this->name,
            'description' => $this->description,
            'tags'        => array_values($tags),
            'is_public'   => $this->is_public,
        ];

        if ($this->setId) {
            VocabularySet::where('user_id', Auth::id())->findOrFail($this->setId)->update($data);
        } else {
            VocabularySet::create($data);
        }

        redirect()->route('vocabulary.sets')->with('message', 'Đã lưu bộ từ!');
    }

    public function render()
    {
        return view('livewire.vocabulary.set-form');
    }
}
