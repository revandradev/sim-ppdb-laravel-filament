<?php
namespace App\Filament\Widgets;

use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\Tarif;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendaftaranOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Statistik Pendaftaran & Siswa Tahun Ini';

    protected function getStats(): array
    {
        $tahun = now()->year;

        $jumlahPendaftaranTahunIni = Pendaftaran::whereYear('created_at', $tahun)->count();
        $jumlahSiswaTahunIni       = Siswa::where('tahun_masuk', $tahun)->count();
        $tarif                     = Tarif::where('is_active', true)->where('kode_tarif', 'KD01')->first();
        $pendapatan                = $jumlahSiswaTahunIni * ($tarif ? $tarif->jumlah : 0);

        return [
            Stat::make('Pendaftaran Tahun Ini', $jumlahPendaftaranTahunIni)
                ->description('Total pendaftar pada tahun ' . $tahun)
                ->color(Color::Blue)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->extraAttributes(['class' => 'text-lg']),
            Stat::make('Siswa Tahun Ini', $jumlahSiswaTahunIni)
                ->description('Total siswa diterima tahun ' . $tahun)
                ->color(Color::Emerald)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->extraAttributes(['class' => 'text-lg']),
            Stat::make('Pendapatan', 'Rp ' . number_format($pendapatan, 0, ',', '.'))
                ->description('Estimasi pendapatan tahun ' . $tahun)
                ->color(Color::Amber)
                ->descriptionIcon('heroicon-m-banknotes')
                ->extraAttributes(['class' => 'text-lg']),
        ];
    }
}
