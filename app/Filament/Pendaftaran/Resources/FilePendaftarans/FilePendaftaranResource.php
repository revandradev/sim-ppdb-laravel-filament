<?php
namespace App\Filament\Pendaftaran\Resources\FilePendaftarans;

use App\Filament\Pendaftaran\Resources\FilePendaftarans\Pages\ManageFilePendaftarans;
use App\Models\FilePendaftaran;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FilePendaftaranResource extends Resource
{
    protected static ?string $model = FilePendaftaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'file_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(1)
                    ->schema([
                        Select::make('file_name')
                            ->label('Berkas Pendaftaran')
                            ->options([
                                'akte'           => 'Akte Kelahiran',
                                'kartu keluarga' => 'Kartu Keluarga',
                                'rapor terakhir' => 'Rapor Terakhir',
                                'pas foto'       => 'Foto Siswa',
                            ])
                            ->required(),
                        FileUpload::make('file_path')
                            ->label('Upload File')
                            ->disk('public')
                            ->directory('file_pendaftaran')
                            ->required(),

                    ]),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_name')
            ->columns([
                TextColumn::make('file_name')
                    ->label('Berkas')
                    ->searchable(),
                TextColumn::make('file_path')
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFilePendaftarans::route('/'),
        ];
    }
}
