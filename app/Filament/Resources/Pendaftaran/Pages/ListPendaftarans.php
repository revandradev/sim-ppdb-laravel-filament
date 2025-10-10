<?php
namespace App\Filament\Resources\pendaftaran\Pages;

use App\Filament\Resources\pendaftaran\PendaftaranResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class Listpendaftaran extends ListRecords
{
    protected static string $resource = PendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'Tahun Ajar Sekarang' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereYear('created_at', date('Y'))),
            'Riwayat'             => Tab::make(),
        ];
    }
}
