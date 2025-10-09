<?php
namespace App\Filament\Resources\pendaftaran;

use App\Filament\Resources\pendaftaran\Pages\CreatePendaftaran;
use App\Filament\Resources\pendaftaran\Pages\EditPendaftaran;
use App\Filament\Resources\pendaftaran\Pages\Listpendaftaran;
use App\Filament\Resources\pendaftaran\Pages\ViewPendaftaran;
use App\Filament\Resources\pendaftaran\Schemas\PendaftaranForm;
use App\Filament\Resources\pendaftaran\Schemas\PendaftaranInfolist;
use App\Filament\Resources\pendaftaran\Tables\pendaftaranTable;
use App\Models\Pendaftaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public static function form(Schema $schema): Schema
    {
        return PendaftaranForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PendaftaranInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return pendaftaranTable::configure($table);
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
            'index'  => Listpendaftaran::route('/'),
            'create' => CreatePendaftaran::route('/create'),
            'view'   => ViewPendaftaran::route('/{record}'),
            'edit'   => EditPendaftaran::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
