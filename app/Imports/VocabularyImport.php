<?php

/**
 * T18: Vocabulary Excel/CSV Import Class
 *
 * Implements Maatwebsite\Excel import for vocabulary data.
 * - Maps CSV columns to Vocabulary model fields
 * - Row-level validation (word/meaning required)
 * - Batch insert (1000 chunks) for performance
 * - Scoped to specific VocabularySet (passed via constructor)
 *
 * Usage: Excel::import(new VocabularyImport($setId), $file);
 *
 * @see https://docs.laravel-excel.com/3.1/imports/basics.html
 */
namespace App\Imports;

use App\Models\Vocabulary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class VocabularyImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, WithBatchInserts
{
    protected $setId;

    public function __construct($setId)
    {
        $this->setId = $setId;
    }

    public function model(array $row): \Illuminate\Database\Eloquent\Model
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

    public function rules(): array
    {
        return [
            'word' => 'required|string|max:255',
            'meaning' => 'required|string|max:1000',
            'pronunciation' => 'nullable|string|max:100',
            '*.description_en' => 'nullable|string|max:1000',
            '*.example' => 'nullable|string|max:1000',
            '*.collocation' => 'nullable|string|max:500',
            '*.related_words' => 'nullable|string|max:500',
            '*.note' => 'nullable|string|max:1000',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}

