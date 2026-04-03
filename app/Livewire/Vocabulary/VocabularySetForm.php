<?php

namespace App\Livewire\Vocabulary;

use Livewire\Component;
use App\Models\VocabularySet;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class VocabularySetForm extends Component
{
    public $setId = null;

    #[Validate('required|max:255')]
    public $name = '';

    public $description = '';
    public $tags = '';
    public $is_public = false;

    public $showModal = false;

    #[On('open-form')]
    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->reset(['name', 'description', 'tags', 'is_public', 'setId']);

        if ($id) {
            $set = auth()->user()->vocabularySets()->findOrFail($id);
            $this->setId = $set->id;
            $this->name = $set->name;
            $this->description = $set->description;
            $this->tags = is_array($set->tags) ? implode(', ', $set->tags) : '';
            $this->is_public = $set->is_public;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate();

        $tagsArray = array_filter(array_map('trim', explode(',', $this->tags)));

        auth()->user()->vocabularySets()->updateOrCreate(
            ['id' => $this->setId],
            [
                'name' => $this->name,
                'description' => $this->description,
                'tags' => array_values($tagsArray) ?: null,
                'is_public' => $this->is_public,
            ]
        );

        $this->showModal = false;
        $this->dispatch('set-saved');
    }

    public function render()
    {
        return view('livewire.vocabulary.vocabulary-set-form');
    }
}
