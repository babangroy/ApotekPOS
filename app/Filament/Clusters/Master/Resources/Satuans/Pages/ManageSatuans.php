<?php

namespace App\Filament\Clusters\Master\Resources\Satuans\Pages;

use App\Filament\Clusters\Master\Resources\Satuans\SatuanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSatuans extends ManageRecords
{
    protected static string $resource = SatuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('md'),
        ];
    }
}
