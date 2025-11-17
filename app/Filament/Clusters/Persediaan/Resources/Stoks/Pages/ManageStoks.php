<?php

namespace App\Filament\Clusters\Persediaan\Resources\Stoks\Pages;

use App\Filament\Clusters\Persediaan\Resources\Stoks\StokResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageStoks extends ManageRecords
{
    protected static string $resource = StokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
