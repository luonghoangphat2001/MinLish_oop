<?php

namespace App\Exports;

use App\Models\Vocabulary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class VocabularyExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    protected $setId;

    public function __construct($setId)
    {
        $this->setId = $setId;
    }

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

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ]],
        ];
    }

    public function title(): string
    {
        return 'Vocabulary';
    }
}

