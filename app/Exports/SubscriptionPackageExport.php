<?php

namespace App\Exports;

use App\Models\SubscriptionPackage;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SubscriptionPackageExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private $no = 0;

    public function collection(): Collection
    {
        return SubscriptionPackage::withCount([
            'subscriptionPackageBooks',
            'subscriptionPackageUsers as active_users_count' => fn($q) => $q->where('expired_date', '>=', date('Y-m-d'))
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Nama Paket Langganan',
            'Harga',
            'Jumlah Buku',
            'Pelanggan Aktif',
        ];
    }

    public function map(mixed $item): array
    {
        return [
            ++$this->no,
            $item->name,
            'Rp ' . number_format($item->price, 0, ',', '.'),
            $item->subscription_package_books_count,
            $item->active_users_count ?: '',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Judul h2 di baris 1
        $sheet->insertNewRowBefore(1, 1);
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'Data Paket Langganan dengan Buku dan Pengguna');
        $sheet->getStyle('A1')->getFont()->setSize(18)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Border seluruh tabel
        $sheet->getStyle("A1:E{$sheet->getHighestRow()}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Header baris 2 tebal warna abu-abu
        return [
            2 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD3D3D3']],
            ],
        ];
    }
}
