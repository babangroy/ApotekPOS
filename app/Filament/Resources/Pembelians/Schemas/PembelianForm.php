<?php

namespace App\Filament\Resources\Pembelians\Schemas;

use App\Models\Barang;
use App\Models\Jenis;
use App\Models\Kategori;
use App\Models\Konversi;
use App\Models\Merek;
use App\Models\Pabrikan;
use App\Models\Satuan;
use App\Support\MoneyHelper;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
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
                        ->searchable()
                        ->options(
                            Barang::query()
                                ->whereHas('konversis')
                                ->with('merek:id,nama')
                                ->select('id', 'nama', 'merek_id')
                                ->orderBy('nama')
                                ->limit(50)
                                ->get()
                                ->mapWithKeys(fn ($barang) => [
                                    $barang->id => "{$barang->nama} - Merek: {$barang->merek->nama}",
                                ])
                        )
                        ->getSearchResultsUsing(function (string $search) {
                            return Barang::query()
                                ->whereHas('konversis')
                                ->with('merek:id,nama')
                                ->select('id', 'nama', 'merek_id')
                                ->where('nama', 'like', "%{$search}%")
                                ->limit(50)
                                ->orderBy('nama')
                                ->get()
                                ->mapWithKeys(fn ($barang) => [
                                    $barang->id => "{$barang->nama} - Merek: {$barang->merek->nama}",
                                ]);
                        })
                        ->afterStateUpdated(fn ($state, callable $set) => $set('satuan_id', null))
                        ->required()
                        ->createOptionForm([
                            Grid::make()
                                ->columns(2)
                                ->schema([
                                    TextInput::make('barcode')
                                        ->label('Barcode Barang')
                                        ->unique('barangs', 'barcode')
                                        ->validationMessages([
                                            'unique' => 'Barcode barang sudah ada'
                                        ])
                                        ->columnSpan(1),

                                    TextInput::make('nama')
                                        ->label('Nama Barang')
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Nama barang wajib di isi'
                                        ])
                                        ->columnSpan(1),
                                ]),                            
                            Grid::make()
                                ->columns(2)
                                ->schema([
                                    self::createNestedSelect('jenis_id', 'Jenis', Jenis::class),
                                    self::createNestedSelect('kategori_id', 'Kategori', Kategori::class),
                                ]),

                            Grid::make()
                                ->columns(2)
                                ->schema([
                                    self::createNestedSelect('merek_id', 'Merek', Merek::class),
                                    self::createNestedSelect('pabrikan_id', 'Pabrikan', Pabrikan::class),
                                ]),

                            self::createNestedSelect('satuan_id', 'Satuan Terkecil', Satuan::class),
                        ])
                        ->createOptionUsing(function (array $data) {
                            try {
                                $barang = Barang::create([
                                    'barcode' => $data['barcode'] ?? null,
                                    'nama' => $data['nama'],
                                    'jenis_id' => $data['jenis_id'],
                                    'kategori_id' => $data['kategori_id'],
                                    'merek_id' => $data['merek_id'],
                                    'pabrikan_id' => $data['pabrikan_id'],
                                    'satuan_id' => $data['satuan_id'],
                                ]);

                                Konversi::create([
                                    'barang_id' => $barang->id,
                                    'satuan_id' => $data['satuan_id'],
                                    'konversi_ke_satuan_terkecil' => 1,
                                    'urutan' => 1,
                                    'satuan_utama' => true,
                                ]);

                                return $barang->id;
                            } catch (\Exception $e) {
                                throw new \Exception("Gagal membuat barang: " . $e->getMessage());
                            }
                        })
                        ->createOptionAction(fn ($action) => $action->modalWidth('3xl')->modalHeading('Buat Barang Baru')),

                    TextInput::make('no_batch')
                        ->disabled(fn (Get $get) => !$get('barang_id'))
                        ->required()
                        ->validationMessages([
                            'required' => 'No. batch wajib di isi'
                        ]),

                    DatePicker::make('tgl_kadaluarsa')
                        ->disabled(fn (Get $get) => !$get('barang_id'))
                        ->required()
                        ->validationMessages([
                            'required' => 'Tanggal kadaluarsa wajib di isi'
                        ]),

                    Select::make('satuan_id')
                        ->disabled(fn (Get $get) => !$get('barang_id'))
                        ->options(function (callable $get) {
                            $barangId = $get('barang_id');

                            if (!$barangId) {
                                return [];
                            }

                            return Konversi::where('barang_id', $barangId)
                                ->with('satuan:id,nama')
                                ->orderBy('urutan')
                                ->get()
                                ->pluck('satuan.nama', 'satuan_id');
                        })
                        ->native(false)
                        ->live()
                        ->required()
                        ->placeholder('Pilih')
                        ->validationMessages([
                            'required' => 'Satuan wajib dipilih',
                        ]),

                    TextInput::make('jumlah')
                        ->disabled(fn (Get $get) => !$get('barang_id'))
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
                        ->disabled(fn (Get $get) => !$get('barang_id'))
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
                        ->disabled(fn (Get $get) => !$get('barang_id'))
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

    private static function createNestedSelect(string $fieldName, string $label, string $modelClass): Select
    {
        $tableName = (new $modelClass)->getTable();
        
        return Select::make($fieldName)
            ->label($label)
            ->options(
                $modelClass::query()
                    ->orderBy('nama')
                    ->pluck('nama', 'id')
            )
            ->searchable()
            ->preload()
            ->required()
            ->validationMessages([
                'required' => "{$label} barang harus di pilih"
            ])
            ->native(false)
            ->columnSpan(1)
            ->createOptionForm([
                TextInput::make('nama')
                    ->label("Nama {$label}")
                    ->required()
                    ->unique($tableName, 'nama')
                    ->validationMessages([
                        'required' => "Nama {$label} wajib di isi",
                        'unique' => "Nama {$label} sudah ada",
                    ])
                    ->columnSpanFull(),
            ])
            ->createOptionUsing(function (array $data) use ($modelClass, $label) {
                try {
                    $model = $modelClass::create([
                        'nama' => $data['nama'],
                    ]);
                    return $model->id;
                } catch (\Exception $e) {
                    throw new \Exception("Gagal membuat {$label}: " . $e->getMessage());
                }
            })
            ->createOptionAction(fn ($action) => $action->modalWidth('md')->modalHeading("Buat {$label}"));
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
