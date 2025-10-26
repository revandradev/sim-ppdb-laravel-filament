<?php
namespace App\Filament\Pendaftaran\Resources\FilePendaftarans\Pages;

use App\Filament\Pendaftaran\Resources\FilePendaftarans\FilePendaftaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;

class ManageFilePendaftarans extends ManageRecords
{
    protected static string $resource = FilePendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Upload berkas')
                ->slideOver()
                ->modalWidth(Width::Medium)
                ->mutateDataUsing(function (array $data): array {
                    $data['user_pendaftaran_id'] = auth('user_pendaftaran')->id();
                    return $data;
                }),
        ];
    }

}
