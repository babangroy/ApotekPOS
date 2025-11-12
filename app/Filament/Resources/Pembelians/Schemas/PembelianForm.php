<?php

namespace App\Filament\Resources\Pembelians\Schemas;

use App\Models\Barang;
use App\Models\Satuan;
use App\Support\MoneyHelper;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class PembelianForm
{
    public function configure(Schema $schema): Schema
    {
        return $schema->components([
            // ======================
            // DETAIL FAKTUR
            // ======================
            Section::make()
                ->label('Detail Faktur')
                ->schema([
                    TextInput::make('no_faktur')
                        ->label('No Faktur')
                        ->required()
                        ->validationMessages(['required' => 'No faktur wajib di isi']),

                    Select::make('supplier_id')
                        ->label('Supplier')
                        ->relationship(name: 'supplier', titleAttribute: 'nama')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->validationMessages(['required' => 'Supplier wajib di pilih']),

                    DatePicker::make('tgl_pembelian')
                        ->label('Tanggal Pembelian')
                        ->required()
                        ->validationMessages([
                            'required' => 'Tanggal pembelian wajib di isi',
                            'date' => 'Format tanggal tidak valid',
                        ]),

                    Select::make('status_pembayaran')
                        ->label('Status Pembayaran')
                        ->options([
                            'Lunas' => 'Lunas',
                            'Dp' => 'Dp',
                            'Belum Bayar' => 'Belum Bayar',
                            'Sebagian' => 'Sebagian',
                        ])
                        ->native(false)
                        ->required()
                        ->live()
                        ->validationMessages(['required' => 'Status pembayaran wajib di pilih']),

                    DatePicker::make('tgl_jth_tempo')
                        ->label('Tgl Jatuh Tempo')
                        ->hidden(fn (Get $get): bool =>
                            empty($get('status_pembayaran')) ||
                            $get('status_pembayaran') === 'Lunas'
                        ),

                    Textarea::make('catatan')
                        ->label('Catatan'),
                ])
                ->columns(3)
                ->columnSpanFull(),

            // ======================
            // DETAIL BARANG
            // ======================
            Repeater::make('pembelian_details')
                ->label('Detail Barang')
                ->table([
                    TableColumn::make('Nama Barang'),
                    TableColumn::make('Batch')->width('150px'),
                    TableColumn::make('Exp.')->width('160px'),
                    TableColumn::make('Satuan')->width('150px'),
                    TableColumn::make('Jumlah')->width('90px'),
                    TableColumn::make('Harga')->width('200px'),
                    TableColumn::make('Subtotal')->width('200px'),
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
                        ->required()
                        ->validationMessages(['required' => 'Nama barang wajib dipilih']),

                    TextInput::make('no_batch')
                        ->required()
                        ->validationMessages([
                            'required' => 'No. batch wajib di isi'
                        ]),

                    DatePicker::make('tgl_kadaluarsa')
                        ->required()
                        ->validationMessages([
                            'required' => 'Tanggal kadaluarsa wajib di isi'
                        ]),

                    Select::make('satuan_id')
                        ->options(Satuan::query()->pluck('nama', 'id'))
                        ->searchable()
                        ->placeholder('Pilih')
                        ->required()
                        ->validationMessages([
                            'required' => 'Satuan wajib di pilih'
                        ]),

                    TextInput::make('jumlah')
                        ->numeric()
                        ->required()
                        ->default(1)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, Get $get) =>
                            self::calculateItemSubtotal($set, $get)
                        )
                        ->validationMessages([
                            'required' => 'Jumlah wajib di isi'
                        ]),

                    TextInput::make('harga')
                        ->required()
                        ->prefix('Rp')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters([','])
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, Get $get) =>
                            self::calculateItemSubtotal($set, $get)
                        )
                        ->validationMessages([
                            'required' => 'Harga wajib di isi'
                        ]),

                    TextInput::make('subtotal_item')
                        ->prefix('Rp')
                        ->readOnly()
                        ->default(0)
                        ->dehydrated(false)
                        ->formatStateUsing(fn ($state) => 
                            MoneyHelper::format($state ?? 0, 0)
                        ),
                ])
                ->reorderable(false)
                ->addActionLabel('Tambah Barang')
                ->live()
                ->afterStateUpdated(fn (Get $get, Set $set) =>
                    self::calculateTotals($set, $get)
                )
                ->columnSpanFull(),

            // ======================
            // DETAIL HARGA
            // ======================
            Section::make('Detail Harga')
                ->schema([
                    TextInput::make('subtotal')
                        ->label('Subtotal')
                        ->prefix('Rp')
                        ->numeric()
                        ->readOnly()
                        ->formatStateUsing(fn ($state) =>
                            MoneyHelper::format($state, 2)
                        ),

                    TextInput::make('diskon')
                        ->label('Diskon')
                        ->prefix('Rp')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters([','])
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, Get $get) =>
                            self::calculateTotals($set, $get)
                        ),

                    TextInput::make('ppn')
                        ->label('PPN (%)')
                        ->suffix('%')
                        ->numeric()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, Get $get) =>
                            self::calculateTotals($set, $get)
                        ),

                    TextInput::make('total_akhir')
                        ->label('Grand Total')
                        ->prefix('Rp')
                        ->numeric()
                        ->readOnly()
                        ->formatStateUsing(fn ($state) =>
                            MoneyHelper::format($state, 2)
                        ),
                ])
                ->columns(4)
                ->columnSpanFull(),
        ]);
    }

    // ============================================================
    // Kalkulasi utama
    // ============================================================
    protected static function calculateItemSubtotal(Set $set, Get $get): void
    {
        $jumlah = (float) ($get('jumlah') ?? 0);
        $harga  = MoneyHelper::parse($get('harga') ?? 0);

        $subtotal = $jumlah * $harga;
        $set('subtotal_item', $subtotal);

        self::calculateTotals($set, $get);
    }

    protected static function calculateSubtotal(Get $get): float
    {
        $items = $get('pembelian_details') ?? [];
        $subtotal = 0.0;

        foreach ($items as $item) {
            $jumlah = (float) ($item['jumlah'] ?? 0);
            $harga  = MoneyHelper::parse($item['harga'] ?? 0);
            $subtotal += $jumlah * $harga;
        }

        return $subtotal;
    }

    protected static function calculateTotals(Set $set, Get $get): void
    {
        $subtotal   = self::calculateSubtotal($get);
        $diskon     = MoneyHelper::parse($get('diskon') ?? 0);
        $ppnPercent = (float) ($get('ppn') ?? 0);

        $ppnAmount  = max(0, ($subtotal - $diskon)) * ($ppnPercent / 100);
        $totalAkhir = max(0, ($subtotal - $diskon)) + $ppnAmount;

        $set('subtotal', $subtotal);
        $set('total_akhir', $totalAkhir);
    }
}
