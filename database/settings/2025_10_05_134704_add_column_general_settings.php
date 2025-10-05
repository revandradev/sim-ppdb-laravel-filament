<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_logo', 'default-logo.png');
        $this->migrator->add('general.site_favicon', 'default-favicon.ico');
    }
};
