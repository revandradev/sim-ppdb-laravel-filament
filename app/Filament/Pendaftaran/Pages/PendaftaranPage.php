<?php
namespace App\Filament\Pendaftaran\Pages;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\UserPendaftaran;
use App\Notifications\UpdatePendaftaran;
use Asmit\FilamentUpload\Enums\PdfViewFit;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;
use Awcodes\Shout\Components\Shout;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Icon;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
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
                                    ->label('Alamat')
                                    ->required()
                                    ->rows(4)
                                    ->maxLength(255),
                                Textarea::make('alamat_domisili')
                                    ->label('Alamat Domisili')
                                    ->required()
                                    ->rows(4)
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
                            ->icon('heroicon-o-arrow-up-on-square')
                            ->schema([
                                FileUpload::make('foto')
                                    ->label('Foto')
                                    ->visibility('public')
                                    ->directory('pendaftaran/foto')
                                    ->openable()
                                    ->nullable(),
                                FileUpload::make('akte_kelahiran')
                                    ->label('Akte Kelahiran')
                                    ->visibility('public')
                                    ->directory('pendaftaran/akte_kelahiran')
                                    ->openable()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->belowContent([
                                        Icon::make(Heroicon::InformationCircle),
                                        'Hanya file PDF yang diizinkan, maksimal ukuran 2MB.',
                                    ])
                                    ->nullable(),
                                AdvancedFileUpload::make('kartu_keluarga')
                                    ->label('Kartu Keluarga Terbaru')
                                    ->pdfPreviewHeight(400)       // Customize preview height
                                    ->pdfDisplayPage(1)           // Set default page
                                    ->pdfToolbar(true)            // Enable toolbar
                                    ->pdfZoomLevel(100)           // Set zoom level
                                    ->pdfFitType(PdfViewFit::FIT) // Set fit type
                                    ->pdfNavPanes(true)           // Enable navigation panes
                                    ->visibility('public')
                                    ->directory('pendaftaran/akte_kelahiran')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->belowContent([
                                        Icon::make(Heroicon::InformationCircle),
                                        'Hanya file PDF yang diizinkan, maksimal ukuran 2MB.',
                                    ])
                                    ->nullable(),
                                FileUpload::make('rapor_terakhir')
                                    ->label('Rapor Terakhir')
                                    ->visibility('public')
                                    ->directory('pendaftaran/rapor_terakhir')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->belowContent([
                                        Icon::make(Heroicon::InformationCircle),
                                        'Hanya file PDF yang diizinkan, maksimal ukuran 2MB.',
                                    ])
                                    ->openable()
                                    ->nullable(),
                                FileUpload::make('ijazah')
                                    ->label('Ijazah')
                                    ->visibility('public')
                                    ->directory('pendaftaran/ijazah')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->belowContent([
                                        Icon::make(Heroicon::InformationCircle),
                                        'Hanya file PDF yang diizinkan, maksimal ukuran 2MB.',
                                    ])
                                    ->openable()
                                    ->nullable(),
                            ]),
                        Step::make('Konfirmasi')
                            ->icon('heroicon-o-check-badge')
                            ->schema([
                                Shout::make('final-step')
                                    ->heading('Konfirmasi dan Kirim')
                                    ->content('Pastikan semua data yang Anda masukkan sudah benar sebelum mengirimkan formulir pendaftaran.')
                                    ->icon('heroicon-o-exclamation-circle')
                                    ->color(Color::Yellow)
                                    ->columnSpanFull(),
                                Radio::make('is_submitted')
                                    ->label('Saya menyatakan bahwa data yang saya isi adalah benar dan saya setuju untuk melanjutkan proses pendaftaran.')
                                    ->options([
                                        0 => 'Tunggu',
                                        1 => 'Setuju',
                                    ])
                                    ->descriptions([
                                        0 => 'Data Anda akan disimpan sebagai draf dan Anda dapat mengeditnya kembali sebelum mengirimkan.',
                                        1 => 'Dengan memilih ini, Anda menyetujui bahwa data yang Anda berikan adalah benar dan siap untuk diproses lebih lanjut.',
                                    ])
                                    ->required(),
                            ]),
                    ])->submitAction(
                        Action::make('save')
                            ->label('Simpan')
                            ->color('primary')
                            ->disabled(fn(): bool => $this->getRecord()?->is_submitted ?? false)
                            ->action('save')
                            ->keyBindings(['mod+s']),
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
