<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    public string $site_name;

    public bool $site_description;

    public static function group(): string
    {
        return 'general';
    }
}
