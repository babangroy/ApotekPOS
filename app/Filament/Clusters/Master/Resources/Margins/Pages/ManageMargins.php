<?php

namespace App\Filament\Clusters\Master\Resources\Margins\Pages;

use App\Filament\Clusters\Master\Resources\Margins\MarginResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMargins extends ManageRecords
{
    protected static string $resource = MarginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('md'),
        ];
    }
}
