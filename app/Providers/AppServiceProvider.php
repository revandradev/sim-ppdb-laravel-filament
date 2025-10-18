<?php
namespace App\Providers;

use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            FilamentAsset::registerScriptData([
                'vapid' => [
                    'publicKey' => config('webpush.vapid.public_key'),
                ],
                'token' => [
                    'csrf' => csrf_token(),
                ],
                'push'  => [
                    'subscribeUrl' => config('app.url') . '/push/subscribe',
                ],
            ]);
        });
    }
}
