<?php
namespace App\Filament\Pendaftaran\Pages;

use App\Models\Pendaftaran;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class PendaftaranPage extends Page
{
    protected string $view = 'filament.pendaftaran.pages.pendaftaran-page';
    public ?array $data    = [];

    public function mount(): void
    {
        $this->form->fill($this->getRecord()?->attributesToArray());
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    TextInput::make('nama_lengkap')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('nisn')
                        ->label('NISN')
                        ->required()
                        ->maxLength(20),
                    TextInput::make('tempat_lahir')
                        ->label('Tempat Lahir')
                        ->required()
                        ->maxLength(100),
                    TextInput::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->type('date')
                        ->required(),
                    TextInput::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->required()
                        ->maxLength(1),
                    TextInput::make('alamat')
                        ->label('Alamat')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('nama_ayah')
                        ->label('Nama Ayah')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('nama_ibu')
                        ->label('Nama Ibu')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('no_hp_ortu')
                        ->label('No HP Orang Tua')
                        ->required()
                        ->maxLength(20),
                    TextInput::make('asal_sekolah')
                        ->label('Asal Sekolah')
                        ->required()
                        ->maxLength(255),
                    FileUpload::make('foto')
                        ->label('Foto')
                        ->nullable(),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->record($this->getRecord())
            ->statePath('data');
    }
    public function save(): void
    {
        $data = $this->form->getState();

        $record = $this->getRecord();

        if (! $record) {
            $record                      = new Pendaftaran();
            $record->user_pendaftaran_id = Auth::id();
        }

        $record->fill($data);
        $record->save();

        if ($record->wasRecentlyCreated) {
            $this->form->record($record)->saveRelationships();
        }

        Notification::make()
            ->success()
            ->title('Saved')
            ->send();
    }
    public function getRecord(): ?Pendaftaran
    {
        return Pendaftaran::query()
            ->first();
    }
}
