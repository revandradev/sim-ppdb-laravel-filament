<?php
namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use App\Models\Pendaftaran;
use Filament\Resources\Pages\CreateRecord;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['pendaftaran_id'])) {
            $data['nama_lengkap'] = Pendaftaran::find($data['pendaftaran_id'])?->nama_lengkap;
        }
        Pendaftaran::where('id', $data['pendaftaran_id'])->update(['is_approved' => true]);
        return $data;
    }
}
