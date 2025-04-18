<?php

namespace App\Providers;

use Carbon\Carbon;
use Filament\Infolists\Infolist;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();

        Carbon::setLocale('es_MX');

        Table::$defaultNumberLocale = 'es_MX';

        Infolist::$defaultNumberLocale = 'es_MX';
    }
}
