<?php

namespace App\Filament\Clusters\Persediaan\Resources\Batches\Pages;

use App\Filament\Clusters\Persediaan\Resources\Batches\BatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ManageBatches extends ManageRecords
{
    protected static string $resource = BatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

// public function getTabs(): array
// {
//     return [
//         'batch' => Tab::make('Per Batch')
//             ->modifyQueryUsing(fn (Builder $query) => $query
//                 ->groupBy('no_batch')
//                 ->selectRaw('no_batch, SUM(jlh_tersedia) as total_tersedia, COUNT(*) as total_batch')
//             ),
//         'barang' => Tab::make('Per Barang')
//             ->modifyQueryUsing(fn (Builder $query) => $query
//                 ->groupBy('barang_id')
//                 ->selectRaw('barang_id, SUM(jlh_tersedia) as total_tersedia, COUNT(*) as total_batch')
//             ),
//     ];
// }
}
