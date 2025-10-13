<?php
namespace App\Filament\Resources\Tarifs;

use App\Filament\Resources\Tarifs\Pages\ManageTarifs;
use App\Models\Tarif;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TarifResource extends Resource
{
    protected static ?string $model                            = Tarif::class;
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_tarif';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()->columnSpanFull()->schema([
                    TextInput::make('kode_tarif')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(12),
                    TextInput::make('nama_tarif')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(12),
                    TextInput::make('jumlah')
                        ->label('Nominal')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->columnSpan(12),
                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->nullable()
                        ->columnSpan(12),
                    Textarea::make('deskripsi')
                        ->label('Keterangan')
                        ->nullable()
                        ->rows(4)
                        ->maxLength(65535)
                        ->columnSpan(12),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_tarif')
            ->columns([
                TextColumn::make('kode_tarif')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_tarif')
                    ->label('Nama Tarif')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jumlah')
                    ->label('Nominal')
                    ->money('IDR', true)
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->sortable(),
                TextColumn::make('deskripsi')
                    ->label('Keterangan')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make()->slideOver()->modalWidth('md'),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTarifs::route('/'),
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
