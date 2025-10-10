<?php
namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Builder;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data) {
                    if (isset($data['pendaftaran_id'])) {
                        $data['nama_lengkap'] = \App\Models\Pendaftaran::find($data['pendaftaran_id'])?->nama_lengkap;
                    }
                    return $data;
                })
                ->modalWidth(Width::ThreeExtraLarge)
                ->slideOver(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'Tahun Ajar Sekarang' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('tahun_masuk', date('Y'))),
            'Riwayat'             => Tab::make(),
        ];
    }
}
