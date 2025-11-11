<?php

namespace App\Filament\Resources\Pembelians\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PembelianInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('kode'),
                TextEntry::make('no_faktur')
                    ->placeholder('-'),
                TextEntry::make('supplier_id')
                    ->numeric(),
                TextEntry::make('tgl_pembelian')
                    ->date(),
                TextEntry::make('tgl_jth_tempo')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status_pembayaran')
                    ->badge(),
                TextEntry::make('subtotal')
                    ->numeric(),
                TextEntry::make('diskon')
                    ->numeric(),
                TextEntry::make('ppn')
                    ->numeric(),
                TextEntry::make('total_akhir')
                    ->numeric(),
                TextEntry::make('catatan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('oleh')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
