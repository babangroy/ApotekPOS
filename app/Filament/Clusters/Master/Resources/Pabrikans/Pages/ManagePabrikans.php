<?php

namespace App\Filament\Clusters\Master\Resources\Pabrikans\Pages;

use App\Filament\Clusters\Master\Resources\Pabrikans\PabrikanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePabrikans extends ManageRecords
{
    protected static string $resource = PabrikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('md'),
        ];
    }
}
