<?php
namespace App\Filament\Pendaftaran\Pages;

use App\Models\Pendaftaran;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;

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
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
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
            $record              = new Pendaftaran();
            $record->is_homepage = true;
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
