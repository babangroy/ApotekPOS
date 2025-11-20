<?php

namespace App\Filament\Clusters\Master\Resources\Hargas\Pages;

use App\Filament\Clusters\Master\Resources\Hargas\HargaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageHargas extends ManageRecords
{
    protected static string $resource = HargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
