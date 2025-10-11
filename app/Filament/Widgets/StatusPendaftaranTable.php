<?php
namespace App\Filament\Widgets;

use App\Models\Pendaftaran;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StatusPendaftaranTable extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Pendaftaran::query()->where('user_pendaftaran_id', Auth::id()))
            ->columns([
                TextColumn::make('nama_lengkap')->label('Nama Lengkap')->searchable()->sortable(),
                TextColumn::make('nisn')->label('NISN')->searchable()->sortable(),
                TextColumn::make('tempat_lahir')->label('Tempat Lahir')->searchable(),
                TextColumn::make('tanggal_lahir')->label('Tanggal Lahir')->date('d-m-Y')->sortable(),
                TextColumn::make('jenis_kelamin')->label('Jenis Kelamin')
                    ->formatStateUsing(fn($state) => $state === 'L' ? 'Laki-laki' : ($state === 'P' ? 'Perempuan' : '-')),
                TextColumn::make('alamat')->label('Alamat')->limit(30),
                ImageColumn::make('foto')->label('Foto')->circular(),
                TextColumn::make('status')->label('Status')->badge()
                    ->color(fn($record) => $record->is_verified ? 'success' : 'gray'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
