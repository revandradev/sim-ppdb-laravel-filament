<?php

namespace App\Filament\Resources\CalonSiswas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CalonSiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_lengkap')
                    ->required(),
                TextInput::make('nisn')
                    ->required(),
                TextInput::make('tempat_lahir')
                    ->required(),
                DatePicker::make('tanggal_lahir')
                    ->required(),
                Select::make('jenis_kelamin')
                    ->options(['L' => 'L', 'P' => 'P'])
                    ->required(),
                TextInput::make('alamat')
                    ->required(),
                TextInput::make('nama_ayah')
                    ->required(),
                TextInput::make('nama_ibu')
                    ->required(),
                TextInput::make('no_hp_ortu')
                    ->required(),
                TextInput::make('asal_sekolah')
                    ->required(),
                TextInput::make('foto')
                    ->default(null),
            ]);
    }
}
