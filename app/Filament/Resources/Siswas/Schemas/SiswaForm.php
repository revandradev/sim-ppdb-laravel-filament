<?php
namespace App\Filament\Resources\Siswas\Schemas;

use App\Models\Pendaftaran;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Log;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        Log::info('Configuring SiswaForm schema');
        return $schema
            ->components([
                Select::make('pendaftaran_id')
                    ->label('Pendaftaran')
                    ->options(
                        Pendaftaran::query()
                            ->where('is_verified', true)
                            ->get()
                            ->mapWithKeys(fn($item) => [
                                $item->id => "{$item->nama_lengkap} - {$item->nisn}",
                            ])
                    )
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('nama_lengkap', $state ? Pendaftaran::find($state)?->nama_lengkap : null);
                    }),
                DatePicker::make('tahun_masuk')
                    ->label('Tahun Masuk')
                    ->native(false)
                    ->displayFormat('Y')
                    ->format('Y')
                    ->default(now()->year)
                    ->required(),
                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                // ->required()
                    ->maxLength(255),
                // ->formatStateUsing(fn(string $state): string => ucwords($state)),
                TextInput::make('nisn')
                    ->label('NISN')
                    ->required()
                    ->numeric()
                    ->maxLength(20),
            ]);
    }
}
