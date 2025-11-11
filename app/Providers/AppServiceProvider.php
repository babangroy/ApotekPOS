<?php

namespace App\Providers;

use Filament\Actions\ButtonAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
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
        TextInput::configureUsing(function (TextInput $component) {
            $component->autocomplete(false);
        });

        Table::configureUsing(function (Table $table): void {
            $table
                ->defaultPaginationPageOption(25)
                ->recordActionsColumnLabel('Aksi')
                ->recordActionsAlignment('end');
                
        });
        
    }
}
