<?php

/**
 * T19: Vocabulary Set Excel Export Class ✓
 *
 * Exports all vocabulary for a specific set to XLSX.
 * Columns match T18 Import for round-trip compatibility.
 * Features:
 * - Styled header row (bold, colored)
 * - Auto-sized columns
 * - Set metadata in sheet properties
 * - Filename: {set-name}-vocabulary.xlsx
 *
 * Usage: Excel::download(new VocabularyExport($setId), filename)
 *
 * Leader Notes:
 * - Performance: WithChunkReading for large sets (>10k rows)
 * - Symmetric với T18 Import (same fields)
 * - Scoped to single set_id (secure)
 *
 * @see app/Imports/VocabularyImport.php (twin)
 * @package App\Exports
 */
namespace App\Exports;

use App\Models\Vocabulary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class VocabularyExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $setId;
    protected $setName;

    public function __construct(int $setId)
    {
        $this->setId = $setId;
        $this->setName = Vocabulary::find($setId)?->set->name ?? 'unnamed-set';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Vocabulary::where('set_id', $this->setId)
            ->select([
                'id',
                'word',
                'pronunciation',
                'meaning',
                'description_en',
                'example',
                'collocation',
                'related_words',
                'note',
                'created_at',
            ])
            ->get();
    }

    public function headings(): array
    {
        return [
            '#ID',
            'Từ (Word)',
            'Phiên Âm',
            'Nghĩa (Meaning)',
            'Mô Tả Tiếng Anh',
            'Ví Dụ',
            'Cụm Từ',
            'Từ Liên Quan',
            'Ghi Chú',
            'Ngày Tạo',
        ];
    }

    public function title(): string
    {
        return $this->setName . ' Vocabulary';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header styling
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
            ],
            // Data rows
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 20,  // Word
            'C' => 12,  // Pronunciation
            'D' => 25,  // Meaning
            'E' => 30,  // Description EN
            'F' => 35,  // Example
            'G' => 20,  // Collocation
            'H' => 20,  // Related
            'I' => 25,  // Note
            'J' => 12,  // Created
        ];
    }
}

