<?php

namespace App\Filament\Clusters\Persediaan\Resources\Batches\Pages;

use App\Filament\Clusters\Persediaan\Resources\Batches\BatchResource;
use Filament\Resources\Pages\ManageRecords;

class ManageBatches extends ManageRecords
{
    protected static string $resource = BatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
