<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    public string $site_name;

    public string $site_description;

    public string $site_logo;
    public string $site_favicon;

    public static function group(): string
    {
        return 'general';
    }
}
