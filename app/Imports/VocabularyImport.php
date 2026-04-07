<?php

namespace App\Imports;

use App\Models\Vocabulary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class VocabularyImport implements ToModel, WithHeadingRow, WithChunkReading, WithValidation, SkipsOnFailure
{
    private $setId;

    public function __construct($setId)
    {
        $this->setId = $setId;
    }

    public function model(array $row)
    {
        return new Vocabulary([
            'set_id' => $this->setId,
            'word' => $row['word'],
            'pronunciation' => $row['pronunciation'] ?? null,
            'meaning' => $row['meaning'],
            'description_en' => $row['description_en'] ?? null,
            'example' => $row['example'] ?? null,
            'collocation' => $row['collocation'] ?? null,
            'related_words' => $row['related_words'] ?? null,
            'note' => $row['note'] ?? null,
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'word' => 'required|string|max:255',
            'meaning' => 'required|string|max:1000',
            'pronunciation' => 'nullable|string|max:255',
            'description_en' => 'nullable|string|max:2000',
            'example' => 'nullable|string|max:2000',
            'collocation' => 'nullable|string|max:1000',
            'related_words' => 'nullable|string|max:1000',
            'note' => 'nullable|string|max:2000',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        // Log failures or handle as needed
    }
}

