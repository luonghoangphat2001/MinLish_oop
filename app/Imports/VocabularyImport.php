<?php

namespace App\Imports;

use App\Models\Vocabulary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;        // Thêm
use Maatwebsite\Excel\Concerns\SkipsErrors;         // Thêm
use Maatwebsite\Excel\Concerns\WithHeadings;        // Thêm (nếu cần)

class VocabularyImport implements 
    ToModel, 
    WithHeadingRow, 
    WithValidation, 
    WithChunkReading,
    SkipsOnError, 
    SkipsErrors
{
    public function __construct(protected $setId) {}

    public function model(array $row): ?Vocabulary
    {
        // === XỬ LÝ TRÙNG TỪ VỰNG ===
        $existing = Vocabulary::where('set_id', $this->setId)
            ->where('word', trim($row['word']))
            ->first();

        if ($existing) {
            // Có thể update nghĩa nếu muốn, hoặc skip
            return null; // skip nếu đã tồn tại
        }

        return new Vocabulary([
            'set_id'          => $this->setId,
            'word'            => trim($row['word']),
            'pronunciation'   => $row['pronunciation'] ?? null,
            'meaning'         => trim($row['meaning']),
            'description_en'  => $row['description_en'] ?? null,
            'example'         => $row['example'] ?? null,
            'collocation'     => $row['collocation'] ?? null,
            'related_words'   => $row['related_words'] ?? null,
            'note'            => $row['note'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'word'       => 'required|string|max:255',
            'meaning'    => 'required|string|max:1000',
            'pronunciation'   => 'nullable|string|max:255',
            'description_en'  => 'nullable|string|max:2000',
            'example'         => 'nullable|string|max:2000',
            'collocation'     => 'nullable|string|max:1000',
            'related_words'   => 'nullable|string|max:1000',
            'note'            => 'nullable|string|max:2000',
        ];
    }

    public function chunkSize(): int
    {
        return 500; // Giảm xuống để an toàn hơn
    }

    // Optional: Trả về heading cho template
    public function headings(): array
    {
        return [
            'word', 'pronunciation', 'meaning', 'description_en',
            'example', 'collocation', 'related_words', 'note'
        ];
    }
}
