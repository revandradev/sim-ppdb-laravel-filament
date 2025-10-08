<?php

namespace App\Filament\Resources\CalonSiswas\Schemas;

use App\Models\CalonSiswa;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CalonSiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_lengkap'),
                TextEntry::make('nisn'),
                TextEntry::make('tempat_lahir'),
                TextEntry::make('tanggal_lahir')
                    ->date(),
                TextEntry::make('jenis_kelamin')
                    ->badge(),
                TextEntry::make('alamat'),
                TextEntry::make('nama_ayah'),
                TextEntry::make('nama_ibu'),
                TextEntry::make('no_hp_ortu'),
                TextEntry::make('asal_sekolah'),
                TextEntry::make('foto')
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (CalonSiswa $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
