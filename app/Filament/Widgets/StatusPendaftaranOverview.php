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
        $deskripsi   = $pendaftaran->is_verified ? "selamat, pendaftaran anda diterima" : "maaf, pendaftaran anda belum diterima";
        return [
            Stat::make('Status Pendaftaran', $pendaftaran->status)
                ->description($deskripsi)
                ->color(Color::Blue)
            // ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->extraAttributes(['class' => 'text-lg']),

        ];
    }
}
