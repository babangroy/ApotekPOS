<?php

namespace App\Filament\Clusters\Persediaan;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class PersediaanCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxStack;

    protected static string | UnitEnum | null $navigationGroup = 'Inventory';
}
