<?php
namespace App\Filament\Resources\Pendaftaran\Schemas;

use App\Models\Pendaftaran;
use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;

class PendaftaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Detail Pendaftaran')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nama_lengkap'),
                        TextEntry::make('nisn'),
                        TextEntry::make('tempat_lahir'),
                        TextEntry::make('tanggal_lahir')
                            ->date(),
                        TextEntry::make('jenis_kelamin')
                            ->badge(),
                        TextEntry::make('alamat'),
                        TextEntry::make('alamat_domisili')
                            ->placeholder('-'),
                        TextEntry::make('nama_ayah'),
                        TextEntry::make('nama_ibu'),
                        TextEntry::make('no_hp_ortu'),
                        TextEntry::make('asal_sekolah'),
                        TextEntry::make('alamat_sekolah_sebelumnya')
                            ->placeholder('-'),
                        TextEntry::make('is_submitted')
                            ->label('Status Pengajuan')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state ? 'Terkirim' : 'Draft'),
                        TextEntry::make('status_verifikasi')
                            ->badge(),
                        TextEntry::make('status_approval')
                            ->badge(),

// Meta
                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->visible(fn(Pendaftaran $record): bool => $record->trashed()),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
                Section::make('Berkas')
                    ->columns(1)
                    ->schema([
                        ImageEntry::make('foto')
                            ->placeholder('-')
                            ->imageHeight('200px'),
                        Actions::make([
                            Action::make('download_image')
                                ->label('Download Image')
                                                                                              // ->icon('heroicon-o-download')
                                ->url(fn($record) => Storage::disk('public')->url($record->foto)) // Generate URL
                                ->openUrlInNewTab(),
                        ]),

                        PdfViewerEntry::make('akte_kelahiran')
                            ->placeholder('-')
                            ->minHeight('40svh'),
                        PdfViewerEntry::make('kartu_keluarga')
                            ->placeholder('-')
                            ->minHeight('40svh'),
                        PdfViewerEntry::make('rapor_terakhir')
                            ->placeholder('-')
                            ->minHeight('40svh'),
                        PdfViewerEntry::make('ijazah')
                            ->placeholder('-')
                            ->minHeight('40svh'),
                    ]),
            ]);
    }
}
