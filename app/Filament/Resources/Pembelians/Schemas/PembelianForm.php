<?php

namespace App\Filament\Resources\Pembelians\Schemas;

use App\Models\Barang;
use App\Models\Satuan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class PembelianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->label('Detail Faktur')
                    ->schema([
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
                            ->native(false)
                            ->required()
                            ->validationMessages([
                                'required' => 'Status pembayaran wajib di pilih'
                            ]),

                        Textarea::make('catatan'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Repeater::make('pembelian_details')
                    ->label('Detail Barang')
                    ->table([
                        TableColumn::make('Nama Barang'),
                        TableColumn::make('Satuan')
                            ->width('200px'),
                        TableColumn::make('Jumlah')
                            ->width('150px'),
                        TableColumn::make('Harga')
                            ->width('220px'),
                    ])
                    ->schema([
                        Select::make('barang_id')
                            ->label('Nama Barang')
                            ->options(
                                Barang::query()
                                    ->with('merek')
                                    ->orderBy('nama')
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(fn ($barang) => [
                                        $barang->id => "{$barang->nama} - Merek: {$barang->merek->nama}",
                                    ])
                            )
                            ->preload()
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search) =>
                                Barang::query()
                                    ->with('merek')
                                    ->where('nama', 'like', "%{$search}%")
                                    ->orWhereHas('merek', fn ($q) => $q->where('nama', 'like', "%{$search}%"))
                                    ->limit(30)
                                    ->get()
                                    ->mapWithKeys(fn ($barang) => [
                                        $barang->id => "{$barang->nama} - Merek: {$barang->merek->nama}",
                                    ])
                            )
                            ->required()
                            ->validationMessages([
                                'required' => 'Nama barang wajib dipilih'
                            ]),

                        Select::make('satuan_id')
                            ->options(Satuan::query()->pluck('nama', 'id'))
                            ->searchable()
                            ->required()
                            ->validationMessages([
                                'required' => 'Satuan wajib di pilih'
                            ]),

                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->required()
                            ->validationMessages([
                                'numeric' => 'Jumlah harus berupa angka',
                                'required' => 'Jumlah wajib di isi',
                            ]),
                        
                        TextInput::make('harga')
                            ->label('Harga')
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->required()
                            ->validationMessages([
                                'required' => 'Harga wajib di isi',
                                'numeric' => 'Harga harus berupa angka'
                            ])
                    ])
                    ->reorderable(false)
                    ->addActionLabel('Tambah Barang')
                    ->columnSpanFull(),
            
                Section::make()
                    ->label('Detail Harga')
                    ->schema([
                    TextInput::make('subtotal')
                        ->label('Subtotal')
                        ->prefix('Rp')
                        ->numeric()
                        ->required()
                        ->validationMessages([
                            'numeric' => 'Subtotal harus berupa angka',
                            'required' => 'Subtotal wajib di isi'
                        ]),
                    
                    TextInput::make('diskon')
                            ->label('Diskon')
                            ->prefix('Rp')
                            ->required()
                            ->numeric()
                            ->validationMessages([
                                'numeric' => 'Diskon harus berupa angka',
                                'required' => 'Diskon wajib di isi',
                            ]),

                    TextInput::make('ppn')
                            ->label('PPN')
                            ->prefix('%')
                            ->required()
                            ->numeric()
                            ->validationMessages([
                                'numeric' => 'PPN harus berupa angka',
                                'required' => 'PPN wajib di isi',
                            ]),

                    TextInput::make('total_akhir')
                            ->label('Grand Total')
                            ->prefix('Rp')
                            ->required()
                            ->numeric()
                            ->validationMessages([
                                'numeric' => 'Grand total harus berupa angka',
                                'required' => 'Grand total wajib di isi',
                            ]),
                ])
                ->columns(4)
                ->columnSpanFull(),
            ]);
    }
}
