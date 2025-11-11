<?php

namespace App\Filament\Resources\Pembelians\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PembelianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no_faktur')
                    ->label('No Faktur')
                    ->required()
                    ->validationMessages([
                        'required' => 'No faktur wajib di isi'
                    ]),

                Select::make('supplier_id')
                    ->label('Supplier')
                    ->Relationship(name: 'supplier', titleAttribute: 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Supplier wajib di pilih'
                    ]),

                DatePicker::make('tgl_pembelian')
                    ->label('Tanggal Pembelian')
                    ->date()
                    ->required()
                    ->validationMessages([
                        'required' => 'Tanggal pembelian wajib di isi',
                        'date' => 'Format tanggal tidak valid',
                    ]),

                DatePicker::make('tgl_jth_tempo')
                    ->label('Tgl Jatuh Tempo')
                    ->date()
                    ->validationMessages([
                        'date' => 'Format tanggal tidak valid'
                    ]),

                Select::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->options(['Lunas' => 'Lunas', 'Dp' => 'Dp', 'Belum Bayar' => 'Belum bayar', 'Sebagian' => 'Sebagian'])
                    ->required()
                    ->validationMessages([
                        'required' => 'Status pembayaran wajib di pilih'
                    ]),

                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Subtotal wajib di isi',
                        'numeric' => 'Format harus berupa angka',
                    ]),

                TextInput::make('diskon')
                    ->required()
                    ->numeric(),

                TextInput::make('ppn')
                    ->required()
                    ->numeric(),

                TextInput::make('total_akhir')
                    ->required()
                    ->numeric(),

                Textarea::make('catatan'),
            ]);
    }
}
