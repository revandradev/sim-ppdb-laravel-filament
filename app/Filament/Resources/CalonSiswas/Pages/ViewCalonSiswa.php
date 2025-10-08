<?php

namespace App\Filament\Resources\CalonSiswas\Pages;

use App\Filament\Resources\CalonSiswas\CalonSiswaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCalonSiswa extends ViewRecord
{
    protected static string $resource = CalonSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
