<?php

namespace App\Filament\Resources\Pembelians\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;

class PembelianInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                RepeatableEntry::make('details')
                    ->label('Detail Barang')
                    ->table([
                        TableColumn::make('Nama Barang')->alignment(Alignment::Center),
                        TableColumn::make('No. Batch')->alignment(Alignment::Center),
                        TableColumn::make('Satuan')->alignment(Alignment::Center),
                        TableColumn::make('Jumlah')->alignment(Alignment::Center),
                        TableColumn::make('Harga')->alignment(Alignment::Center),
                        TableColumn::make('Sub Total')->alignment(Alignment::Center),
                        TableColumn::make('Diskon')->alignment(Alignment::Center),
                        TableColumn::make('PPN')->alignment(Alignment::Center),
                        TableColumn::make('Total Akhir')->alignment(Alignment::Center),
                    ])
                    ->schema([                      
                        TextEntry::make('barang_nama_with_merek'),
                        TextEntry::make('batch.no_batch')->alignCenter(),
                        TextEntry::make('satuan.nama')->alignCenter(),
                        TextEntry::make('jumlah')->alignCenter(),
                        TextEntry::make('harga')->money('IDR')->alignEnd(),
                        TextEntry::make('sub_total')->money('IDR')->alignEnd(),
                        TextEntry::make('diskon')->money('IDR')->alignEnd(),
                        TextEntry::make('ppn')->money('IDR')->alignEnd(),
                        TextEntry::make('total_akhir')->money('IDR')->alignEnd(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
