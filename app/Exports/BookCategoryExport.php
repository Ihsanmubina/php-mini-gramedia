<?php

namespace App\Exports;

use App\Models\BookCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookCategoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private int $no = 0;

    public function collection(): Collection
    {
        return BookCategory::all();
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Nama Kategori',
        ];
    }

    public function map(mixed $item): array
    {
        return [
            ++$this->no,
            $item->name,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle("A1:B{$sheet->getHighestRow()}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD3D3D3']],
            ],
        ];
    }
}
