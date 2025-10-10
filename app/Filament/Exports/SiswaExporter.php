<?php
namespace App\Filament\Exports;

use App\Models\Siswa;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class SiswaExporter extends Exporter
{
    protected static ?string $model = Siswa::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id')
            //     ->label('ID'),
            // ExportColumn::make('pendaftaran.nama_lengkap')->label('Nama Lengkap'),
            ExportColumn::make('tahun_masuk'),
            // ExportColumn::make('nama_lengkap'),
            ExportColumn::make('nisn'),
            ExportColumn::make('verifikator'),
            ExportColumn::make('foto'),
            ExportColumn::make('wali'),
            ExportColumn::make('created_at')->label('Tanggal Dibuat'),
            // ExportColumn::make('updated_at'),
            // ExportColumn::make('deleted_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor data siswa selesai. ' . Number::format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }
}
