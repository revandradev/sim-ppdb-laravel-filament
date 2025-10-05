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
                            ->previewable(false)
                            ->visibility('public')
                            ->directory('site-logos')
                            ->maxSize(1024) // Maksimum ukuran file dalam KB
                            ->nullable()
                            ->imageEditor()
                            ->getUploadedFileNameForStorageUsing(
                                function ($file) {
                                    $extension = $file->getClientOriginalExtension();
                                    return 'logo_situs.' . $extension;
                                }
                            ),
                        FileUpload::make('site_favicon')
                            ->label('Favicon Situs')
                            ->image()
                            ->previewable(false)
                            ->visibility('public')
                            ->directory('site-favicons')
                            ->maxSize(1024) // Maksimum ukuran file dalam KB
                            ->nullable()
                            ->imageEditor()
                            ->getUploadedFileNameForStorageUsing(
                                function ($file) {
                                    $extension = $file->getClientOriginalExtension();
                                    return 'logo_favicons.' . $extension;
                                }
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
