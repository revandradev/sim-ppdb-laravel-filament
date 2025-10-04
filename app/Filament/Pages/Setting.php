<?php
namespace App\Filament\Pages;

use App\Settings\GeneralSetting;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class Setting extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = GeneralSetting::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pengaturan Umum')
                    ->description('Ubah nama dan deskripsi situs sesuai kebutuhan aplikasi Anda.')
                    ->aside()
                    ->schema([
                        TextInput::make('site_name')
                            ->required(),
                        Textarea::make('site_description')->autosize()->rows(5)
                            ->required(),

                    ])->columnSpanFull()
                ,
            ]);
    }
}
