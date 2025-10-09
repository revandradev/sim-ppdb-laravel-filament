<?php
namespace App\Filament\Resources\Siswas\Schemas;

// use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Siswa')
                    ->schema([
                        TextEntry::make('nama_lengkap')->label('Nama Lengkap'),
                        TextEntry::make('nisn')->label('NISN'),
                        TextEntry::make('tahun_masuk')->label('Tahun Masuk'),
                        TextEntry::make('pendaftaran_id')->label('ID Pendaftaran'),
                    ]),
                Section::make('Info Detail')
                    ->schema([
                        TextEntry::make('pendaftaran.tempat_lahir')->label('Tempat Lahir'),
                        TextEntry::make('tanggal_lahir')->label('Tanggal Lahir'),
                        TextEntry::make('jenis_kelamin')->label('Jenis Kelamin')
                            ->formatStateUsing(fn($state) => $state === 'L' ? 'Laki-laki' : ($state === 'P' ? 'Perempuan' : '-')),
                        TextEntry::make('pendaftaran.alamat')->label('Alamat'),
                        TextEntry::make('nama_ayah')->label('Nama Ayah'),
                        TextEntry::make('nama_ibu')->label('Nama Ibu'),
                        TextEntry::make('no_hp_ortu')->label('No HP Orang Tua'),
                        TextEntry::make('asal_sekolah')->label('Asal Sekolah'),
                        TextEntry::make('foto')->label('Foto'),
                    ]),
            ]);
    }
}
