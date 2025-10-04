<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'RevanDev');
        $this->migrator->add('general.site_description', 'A Laravel package for managing settings.');
    }
};
