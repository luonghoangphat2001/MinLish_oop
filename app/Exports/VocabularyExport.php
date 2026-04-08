<?php

namespace App\Exports;

use App\Models\Vocabulary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VocabularyExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected $setId) {}

    public function collection()
    {
        return Vocabulary::where('set_id', $this->setId)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Word',
            'Pronunciation',
            'Meaning',
            'Description EN',
            'Example',
            'Collocation',
            'Related Words',
            'Note',
        ];
    }

    public function map($vocabulary): array
    {
        return [
            $vocabulary->id,
            $vocabulary->word,
            $vocabulary->pronunciation,
            $vocabulary->meaning,
            $vocabulary->description_en,
            $vocabulary->example,
            $vocabulary->collocation,
            $vocabulary->related_words,
            $vocabulary->note,
        ];
    }
}
