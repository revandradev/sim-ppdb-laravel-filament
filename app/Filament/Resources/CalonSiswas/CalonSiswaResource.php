<?php

namespace App\Filament\Resources\CalonSiswas;

use App\Filament\Resources\CalonSiswas\Pages\CreateCalonSiswa;
use App\Filament\Resources\CalonSiswas\Pages\EditCalonSiswa;
use App\Filament\Resources\CalonSiswas\Pages\ListCalonSiswas;
use App\Filament\Resources\CalonSiswas\Pages\ViewCalonSiswa;
use App\Filament\Resources\CalonSiswas\Schemas\CalonSiswaForm;
use App\Filament\Resources\CalonSiswas\Schemas\CalonSiswaInfolist;
use App\Filament\Resources\CalonSiswas\Tables\CalonSiswasTable;
use App\Models\CalonSiswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CalonSiswaResource extends Resource
{
    protected static ?string $model = CalonSiswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function form(Schema $schema): Schema
    {
        return CalonSiswaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CalonSiswaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CalonSiswasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCalonSiswas::route('/'),
            'create' => CreateCalonSiswa::route('/create'),
            'view' => ViewCalonSiswa::route('/{record}'),
            'edit' => EditCalonSiswa::route('/{record}/edit'),
        ];
    }
}
