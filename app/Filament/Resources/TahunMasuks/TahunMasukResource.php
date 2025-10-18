<?php
namespace App\Filament\Resources\TahunMasuks;

use App\Filament\Resources\TahunMasuks\Pages\ManageTahunMasuks;
use App\Models\TahunMasuk;
use App\Models\UserPendaftaran;
use App\Notifications\UpdatePendaftaran;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;
use UnitEnum;

class TahunMasukResource extends Resource
{
    protected static ?string $model                            = TahunMasuk::class;
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()->columnSpanFull()->schema([
                    TextInput::make('tahun')
                        ->markAsRequired()
                        ->rules(['required', 'numeric'])
                        ->validationMessages([
                            'required' => 'Kolom :attribute wajib di isi',
                            'max'      => 'Maksimal :attribute adalah 4 karakter',
                            'numeric'  => 'Kolom :attribute harus berupa angka',
                        ])

                        ->columnSpan(12),                         // Mengisi 6 dari 12 kolom
                    Toggle::make('is_aktif')->columnSpan(12), // Mengisi 6 dari 12 kolom
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description('Hanya satu tahun masuk yang aktif')
            ->columns([
                TextColumn::make('tahun')
                    ->label('Tahun Masuk')
                    ->searchable()
                    ->width('20%'),
                ToggleColumn::make('is_aktif')
                    ->label('Aktif'),
                // IconColumn::make('is_aktif')
                //     ->label('Aktif')
                //     ->boolean(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->after(function () {
                    $user = UserPendaftaran::query()->where('email', 'revandra@pendaftaran.com')->first();
                    Log::info("Notifikasi dikirim ke: {$user->email}");
                    $user->notify(new UpdatePendaftaran());
                }),
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
            'index' => ManageTahunMasuks::route('/'),
        ];
    }
}
