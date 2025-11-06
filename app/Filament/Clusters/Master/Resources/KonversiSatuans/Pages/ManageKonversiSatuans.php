<?php

namespace App\Filament\Clusters\Master\Resources\KonversiSatuans\Pages;

use App\Filament\Clusters\Master\Resources\KonversiSatuans\KonversiSatuanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageKonversiSatuans extends ManageRecords
{
    protected static string $resource = KonversiSatuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('2xl'),
        ];
    }
}
