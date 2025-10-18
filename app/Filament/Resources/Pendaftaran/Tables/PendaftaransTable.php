<?php
namespace App\Filament\Resources\pendaftaran\Tables;

use App\Models\UserPendaftaran;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class pendaftaranTable
{

    public static function sendNotifToRegistrant($record, $is_verified)
    {
        $UserPendaftaran = UserPendaftaran::query()->where('id', $record->user_pendaftaran_id)->first();
        Notification::make()
            ->title('Status Pendaftaran')
            ->body($is_verified ? 'Selamat! Pendaftaran Anda telah diverifikasi.' : 'Pendaftaran Anda belum diverifikasi.')
            ->success()
            ->sendToDatabase($UserPendaftaran, isEventDispatched: true);
    }
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
                    ->toggleable(isToggledHiddenByDefault: true)
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
                Action::make('verifikasi')
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
                        self::sendNotifToRegistrant($record, $record->is_verified);
                    }),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);

    }
}
