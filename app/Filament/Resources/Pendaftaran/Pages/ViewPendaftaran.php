<?php
namespace App\Filament\Resources\pendaftaran\Pages;

use App\Filament\Resources\pendaftaran\PendaftaranResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPendaftaran extends ViewRecord
{
    protected static string $resource = PendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }
}
