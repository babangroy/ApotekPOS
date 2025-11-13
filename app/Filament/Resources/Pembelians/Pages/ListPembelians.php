<?php

namespace App\Filament\Resources\Pembelians\Pages;

use App\Filament\Resources\Pembelians\PembelianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPembelians extends ListRecords
{
    protected static string $resource = PembelianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false),
        ];
    }

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua'),
            'lunas' => Tab::make('Lunas')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'Lunas')),
            'dp' => Tab::make('Dp')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'Dp')),
            'sebagian' => Tab::make('Sebagian')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'Sebagian')),
            'belum' => Tab::make('Belum Bayar')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'Belum Bayar')),
        ];
    }
}