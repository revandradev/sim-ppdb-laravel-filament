<?php
namespace App\Filament\Resources\pendaftaran\Pages;

use App\Filament\Resources\pendaftaran\PendaftaranResource;
use Filament\Resources\Pages\ListRecords;

class Listpendaftaran extends ListRecords
{
    protected static string $resource = PendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
