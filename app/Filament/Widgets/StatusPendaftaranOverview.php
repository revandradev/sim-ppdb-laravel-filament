<?php
namespace App\Filament\Widgets;

use App\Models\Pendaftaran;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatusPendaftaranOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $pendaftaran = Pendaftaran::query()->where('user_pendaftaran_id', Auth::id())->first();
        $status      = $pendaftaran ? ($pendaftaran->is_verified ? "Diterima" : "Belum Diterima") : "Belum mendaftar";
        $deskripsi   = $pendaftaran ? ($pendaftaran->is_verified ? "selamat, pendaftaran anda diterima" : "maaf, pendaftaran anda belum diterima") : "Pendaftaran tidak ditemukan";
        return [
            Stat::make('Status Pendaftaran', $status)
                ->description($deskripsi)
                ->color(Color::Blue)
            // ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->extraAttributes(['class' => 'text-lg']),

        ];
    }
}
