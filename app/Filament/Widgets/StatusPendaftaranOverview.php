<?php
namespace App\Filament\Widgets;

use App\Models\Pendaftaran;
use App\Models\TahunMasuk;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatusPendaftaranOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $pendaftaran          = Pendaftaran::query()->where('user_pendaftaran_id', Auth::id())->first();
        $status               = $pendaftaran ? $pendaftaran->status_verifikasi : "Belum mendaftar";
        $deskripsi            = $pendaftaran ? ($pendaftaran->status_verifikasi ? "Pendaftaran anda sudah terverifikasi" : "maaf, pendaftaran anda belum terverifikasi") : "Pendaftaran tidak ditemukan";
        $diterima             = $pendaftaran ? $pendaftaran->status_approval : "Belum mendaftar";
        $deskripsiDiterima    = $pendaftaran ? ($pendaftaran->status_approval ? "Selamat, anda diterima" : "maaf, anda belum diterima") : "Pendaftaran tidak ditemukan";
        $pembukaanPendaftaran = TahunMasuk::query()->where('is_aktif', true)->first();
        return [
            Stat::make('Status Pendaftaran', $status)
                ->description($deskripsi)
                ->color(Color::Blue)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->extraAttributes(['class' => 'text-lg']),
            Stat::make('Status Penerimaan', $diterima)
                ->description($deskripsiDiterima)
                ->color(Color::Green)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->extraAttributes(['class' => 'text-lg']),
            Stat::make('Pendaftaran', $pembukaanPendaftaran ? $pembukaanPendaftaran->tahun : "Pendaftaran ditutup")
                ->description($pembukaanPendaftaran ? "Pendaftaran dibuka" : "Pendaftaran ditutup")
                ->color(Color::Green)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->extraAttributes(['class' => 'text-lg']),
        ];
    }
}
