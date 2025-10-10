<?php
namespace App\Filament\Resources\Siswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tahun_masuk')
                    ->label('Tahun Masuk')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nisn')
                    ->label('Nomor Induk Siswa Nasional (NISN)')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('verifikator')
                    ->label('Verifikator')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->mutateDataUsing(function (array $data) {
                    if (isset($data['pendaftaran_id'])) {
                        $data['nama_lengkap'] = \App\Models\Pendaftaran::find($data['pendaftaran_id'])?->nama_lengkap;
                    }
                    return $data;
                })
                    ->modalWidth(Width::ThreeExtraLarge)
                    ->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
