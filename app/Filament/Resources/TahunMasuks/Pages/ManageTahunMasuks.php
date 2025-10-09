<?php
namespace App\Filament\Resources\TahunMasuks\Pages;

use App\Filament\Resources\TahunMasuks\TahunMasukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTahunMasuks extends ManageRecords
{
    protected static string $resource = TahunMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->modalWidth('md'),
        ];
    }
}
