<?php
namespace App\Filament\Resources\Siswas\Schemas;

use App\Models\Pendaftaran;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nisn')
                    ->label('Nomor Induk Siswa Nasional (NISN)')
                    ->rules(fn($record) => [
                        'required',
                        'unique:siswa,nisn,' . ($record?->id ?? 'NULL'),
                    ])
                    ->validationMessages([
                        'required' => 'Kolom nomor induk siswa nasional (NISN) wajib diisi.',
                        'unique'   => 'Kolom nomor induk siswa nasional (NISN) sudah terdaftar.',
                    ])
                    ->numeric()
                    ->maxLength(20),
                Select::make('pendaftaran_id')
                    ->label('Pendaftaran')
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Kolom pendaftaran wajib dipilih.',
                    ])
                    ->options(
                        Pendaftaran::query()
                            ->where('is_verified', true)
                            ->get()
                            ->mapWithKeys(fn($item) => [
                                $item->id => "{$item->nama_lengkap} - {$item->nisn}",
                            ])
                    )
                    ->searchable()
                    ->required(),
                Select::make('tahun_masuk')
                    ->label('Tahun Masuk')
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Kolom tahun masuk wajib dipilih.',
                    ])
                    ->options(
                        \App\Models\TahunMasuk::query()
                            ->where('is_aktif', true)
                            ->pluck('tahun', 'tahun')
                    )
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('tahun_masuk', $state);
                    }),
            ]);
    }
}
