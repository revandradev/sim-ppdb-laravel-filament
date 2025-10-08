<?php
namespace App\Filament\Resources\CalonSiswas\Pages;

use App\Filament\Resources\CalonSiswas\CalonSiswaResource;
use Filament\Resources\Pages\ListRecords;

class ListCalonSiswas extends ListRecords
{
    protected static string $resource = CalonSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
