<?php
namespace App\Filament\Resources\Siswas\Tables;

use App\Filament\Exports\SiswaExporter;
use App\Models\Pendaftaran;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tahun_masuk')
                    ->label('Tahun Masuk')
                    ->sortable()
                    ->searchable()
                    ->width('10%'),
                TextColumn::make('nisn')
                    ->label('Nomor Induk Siswa Nasional (NISN)')
                    ->sortable()
                    ->searchable()
                    ->width('10%')
                    ->wrap(),
                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('verifikator')
                    ->label('Verifikator')
                    ->sortable()
                    ->searchable(),

            ])
            ->defaultSort('nama_lengkap', 'desc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(SiswaExporter::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->mutateDataUsing(function (array $data) {
                    if (isset($data['pendaftaran_id'])) {
                        $data['nama_lengkap'] = \App\Models\Pendaftaran::find($data['pendaftaran_id'])?->nama_lengkap;
                    }
                    return $data;
                })->using(function (Model $record, array $data): Model {
                    $record->update($data);
                    Pendaftaran::where('id', $data['pendaftaran_id'])->update(['is_approved' => true]);
                    return $record;
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
