<?php

namespace App\Providers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
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

        CreateAction::configureUsing(function (CreateAction $action) {
            $action
                ->label('Tambah')
                ->icon(Heroicon::Plus);

            $action->successNotification(
                Notification::make()
                    ->success()
                    ->title('Berhasil')
                    ->body('Data berhasil ditambahkan')
                    ->color(Color::Green),
            );
        });

        EditAction::configureUsing(function (EditAction $action) {
            $action->successNotification(
                Notification::make()
                    ->success()
                    ->title('Berhasil')
                    ->body('Data berhasil diubah')
                    ->color(Color::Green),
            );
        });

        DeleteAction::configureUsing(function (DeleteAction $action) {
            $action->successNotification(
                Notification::make()
                    ->success()
                    ->title('Berhasil')
                    ->body('Data berhasil dihapus')
                    ->color(Color::Green),
            );
        });        
        
    }
}