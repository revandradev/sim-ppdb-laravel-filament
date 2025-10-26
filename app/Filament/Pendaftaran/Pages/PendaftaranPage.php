<?php
namespace App\Filament\Pendaftaran\Pages;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\UserPendaftaran;
use App\Notifications\UpdatePendaftaran;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class PendaftaranPage extends Page
{
    protected string $view                                      = 'filament.pendaftaran.pages.pendaftaran-page';
    protected static ?string $title                             = 'Pendaftaran';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    public ?array $data                                         = [];

    public function mount(): void
    {
        $this->form->fill($this->getRecord()?->attributesToArray());
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Wizard::make([
                        Step::make('Data Pribadi')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
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
                                Radio::make('jenis_kelamin')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'L' => 'Laki-laki',
                                        'P' => 'Perempuan',
                                    ])
                                    ->required(),
                                Textarea::make('alamat')
                                    ->label('Alamat Domisili')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Step::make('Data Orang Tua')
                            ->icon('heroicon-o-users')
                            ->schema([
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

                            ]),
                        Step::make('Data Sekolah & Lainnya')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                TextInput::make('asal_sekolah')
                                    ->label('Asal Sekolah')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('alamat_sekolah_sebelumnya')
                                    ->label('Alamat Sekolah Sebelumnya')
                                    ->required()
                                    ->rows(4)
                                    ->maxLength(255),
                            ]),
                        Step::make('Berkas pendaftaran')
                            ->icon('heroicon-o-check-circle')
                            ->schema([
                                FileUpload::make('foto')
                                    ->label('Foto')
                                    ->visibility('public')
                                    ->directory('pendaftaran/foto')
                                    ->nullable(),
                                FileUpload::make('akte_kelahiran')
                                    ->label('Akte Kelahiran')
                                    ->visibility('public')
                                    ->directory('pendaftaran/akte_kelahiran')
                                    ->nullable(),
                                FileUpload::make('kartu_keluarga')
                                    ->label('Kartu Keluarga')
                                    ->visibility('public')
                                    ->directory('pendaftaran/kartu_keluarga')
                                    ->nullable(),
                                FileUpload::make('rapor_terakhir')
                                    ->label('Rapor Terakhir')
                                    ->visibility('public')
                                    ->directory('pendaftaran/rapor_terakhir')
                                    ->nullable(),
                                FileUpload::make('ijazah')
                                    ->label('Ijazah')
                                    ->visibility('public')
                                    ->directory('pendaftaran/ijazah')
                                    ->nullable(),
                            ]),
                    ])->submitAction(
                        Action::make('save')
                            ->label('Perbarui data diri')
                            ->color('primary')
                            ->requiresConfirmation()
                            ->modalHeading('Konfirmasi penyimpanan')
                            ->modalDescription('Yakin ingin menyimpan perubahan data?')
                            ->modalSubmitActionLabel('Simpan')
                        // ->modalIcon(\Filament\Support\Icons\Heroicon::oQuestionMarkCircle) // opsional
                        // ->disabled(fn(): bool => $this->getRecord()?->is_submitted ?? false)
                        // ->submit('save')
                            ->action('save')
                            ->keyBindings(['mod+s'])
                    ),

                ]),
                // ->livewireSubmitHandler('save'),
            ])
            ->record($this->getRecord())
            ->statePath('data');
    }
    public function save(): void
    {
        $data   = $this->form->getState();
        $user   = Auth::user();
        $record = $this->getRecord();

        if (! $record) {
            $record                      = new Pendaftaran();
            $record->user_pendaftaran_id = Auth::id();
        }
        // $data['is_submitted'] = true;
        // dd($data);
        $record->fill($data);
        $record->save();

        if ($record->wasRecentlyCreated) {
            $this->form->record($record)->saveRelationships();
        }

        Notification::make()
            ->success()
            ->title('Data diri berhasil diperbarui')
            ->send();
        $recipient = User::query()->where('email', 'admin@example.com')->first();
        $user      = UserPendaftaran::query()->where('id', Auth::id())->first();
        Notification::make()
            ->success()
            ->title("Data diri {$user->nama_lengkap} berhasil diperbarui")
            ->broadcast($recipient);
        $user->notify(new UpdatePendaftaran());
    }
    public function getRecord(): ?Pendaftaran
    {
        return Pendaftaran::query()->where('user_pendaftaran_id', Auth::id())
            ->first();
    }
}
