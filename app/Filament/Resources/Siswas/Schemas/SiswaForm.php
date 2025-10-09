<?php
namespace App\Filament\Resources\Siswas\Schemas;

use App\Models\Pendaftaran;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                            ->pluck('nama_lengkap', 'id')
                    )
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $nama = null;
                        Log::info('Selected Pendaftaran ID: ' . $state);
                        if ($state) {
                            $nama = \App\Models\Pendaftaran::find($state)?->nama_lengkap;
                        }
                        $set('nama_lengkap', $nama);
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
                    ->required()
                    ->maxLength(255)->disabled(),
                TextInput::make('nisn')
                    ->label('NISN')
                    ->required()
                    ->maxLength(20),
            ]);
    }
}
