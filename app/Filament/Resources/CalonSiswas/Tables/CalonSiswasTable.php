<?php
namespace App\Filament\Resources\CalonSiswas\Tables;

use Filament\Actions\Action as ActionsAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CalonSiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->searchable(),
                TextColumn::make('is_verified')
                    ->label('Terverifikasi')
                    ->formatStateUsing(fn($state) => $state ? '✅' : '❌'),
                TextColumn::make('nisn')
                    ->searchable(),
                TextColumn::make('tempat_lahir')
                    ->searchable(),
                TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                TextColumn::make('jenis_kelamin')
                    ->badge(),
                TextColumn::make('alamat')
                    ->searchable(),
                TextColumn::make('nama_ayah')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('nama_ibu')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('no_hp_ortu')
                    ->searchable(),
                TextColumn::make('asal_sekolah')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('foto')
                    ->toggleable(isToggledHiddenByDefault: true)
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
                ViewAction::make(),
                EditAction::make(),
                ActionsAction::make('verifikasi')
                    ->label(fn($record) => $record->is_verified ? 'Batalkan Verifikasi' : 'Verifikasi')
                    ->color(fn($record) => $record->is_verified ? 'warning' : 'success')
                    ->icon(fn($record) => $record->is_verified ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->modalHeading(fn($record) => $record->is_verified ? 'Batalkan Verifikasi?' : 'Verifikasi Siswa?')
                    ->modalDescription(fn($record) => $record->is_verified
                            ? 'Apakah Anda yakin ingin membatalkan verifikasi siswa ini?'
                            : 'Apakah Anda yakin ingin memverifikasi siswa ini?'
                    )
                    ->action(function ($record) {
                        $record->is_verified = ! $record->is_verified;
                        $record->save();

                        Notification::make()
                            ->title($record->is_verified ? 'Siswa berhasil diverifikasi' : 'Status verifikasi dibatalkan')
                            ->success()
                            ->send();
                    }),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
