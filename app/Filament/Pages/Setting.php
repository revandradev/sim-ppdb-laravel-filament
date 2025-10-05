<?php
namespace App\Filament\Pages;

use App\Settings\GeneralSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use UnitEnum;

class Setting extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings     = GeneralSetting::class;
    protected static ?int $navigationSort = 2;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan'; // Tambahkan ini

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pengaturan Umum')
                    ->description('Ubah nama dan deskripsi situs sesuai kebutuhan aplikasi Anda.')
                    ->aside()
                    ->schema([
                        TextInput::make('site_name')->label('Nama Situs')
                            ->required(),
                        FileUpload::make('site_logo')
                            ->label('Logo Situs')
                            ->image()
                            ->directory('site-logos')
                            ->maxSize(1024) // Maksimum ukuran file dalam KB
                            ->nullable()
                            ->visibility('public')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend('site-logo.'),
                            ),
                        Textarea::make('site_description')
                            ->label('Deskripsi Situs')
                            ->autosize()->rows(5)
                            ->required(),

                    ])->columnSpanFull()
                ,
            ]);
    }
}
