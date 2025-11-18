<?php

namespace App\Filament\Clusters\Master\Resources\Costumers\Pages;

use App\Filament\Clusters\Master\Resources\Costumers\CostumerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCostumers extends ManageRecords
{
    protected static string $resource = CostumerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('md'),
        ];
    }
}
