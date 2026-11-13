<?php

namespace App\Exports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BookExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private $no = 0;

    public function collection(): Collection
    {
        return Book::with('bookCategory')->get();
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Alamat Gambar Sampul Buku',
            'Nama Kategori Buku',
            'Judul Buku',
            'Penulis',
            'Penerbit',
            'Tanggal Rilis',
            'Jumlah Halaman',
            'Bahasa',
            'Harga',
        ];
    }

    public function map(mixed $item): array
    {
        return [
            ++$this->no,
            asset($item->cover),
            $item->bookCategory?->name ?? '-',
            $item->title,
            $item->writer,
            $item->publisher,
            $item->release_date,
            $item->page_of_book,
            $item->language,
            'Rp ' . number_format($item->price, 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Border seluruh tabel
        $sheet->getStyle("A1:J{$sheet->getHighestRow()}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Header tebal dengan warna abu-abu
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD3D3D3']],
            ],
        ];
    }
}
