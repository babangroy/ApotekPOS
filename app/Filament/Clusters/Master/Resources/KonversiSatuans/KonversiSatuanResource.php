<?php

namespace App\Filament\Clusters\Master\Resources\KonversiSatuans;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\KonversiSatuans\Pages\ManageKonversiSatuans;
use App\Models\Barang;
use App\Models\KonversiSatuan;
use App\Models\Satuan;
use BackedEnum;
use Closure;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use UnitEnum;

class KonversiSatuanResource extends Resource
{
    protected static ?string $model = KonversiSatuan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static string | UnitEnum | null $navigationGroup = 'Produk';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'barang_id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Contoh Pengisian')
                ->icon(Heroicon::OutlinedLightBulb)
                ->description(new HtmlString('
                    <div class="space-y-2 text-sm">
                        <div class="leading-relaxed">
                            <strong>Level 1:</strong> Tablet, jumlah 1 • 
                            <strong>Level 2:</strong> Strip, jumlah 10 • 
                            <strong>Level 3:</strong> Box, jumlah 10
                        </div>
                        <div class="font-semibold text-blue-600">
                            Jadi → 1 Box = 10 Strip = 100 Tablet
                        </div>
                    </div>
                '))
                ->columnSpanFull(),

            Select::make('barang_id')
                ->label('Nama Barang')
                ->options(
                    Barang::with('merek')
                        ->get()
                        ->mapWithKeys(fn ($barang) => [
                            $barang->id => "{$barang->nama} (Merek: " . ($barang->merek->nama ?? 'Tanpa Merek') . ")"
                        ])
                )
                ->required()
                ->unique(ignoreRecord: true)
                ->validationMessages([
                    'required' => 'Nama barang wajib dipilih.',
                    'unique' => 'Konversi satuan untuk barang tersebut sudah ada.',
                ])
                ->searchable()
                ->native(false)
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
                    $barang = Barang::find($state);

                    if ($barang) {
                        $set('sat_lv_1', $barang->satuan_id);
                        $set('jlh_lv_1', 1);
                    } else {
                        $set('sat_lv_1', null);
                        $set('jlh_lv_1', null);
                    }
                })
                ->columnSpanFull(),

            Select::make('sat_lv_1')
                ->label('Satuan Level 1')
                ->options(Satuan::pluck('nama', 'id'))
                ->required()
                ->disabled()
                ->dehydrated()
                ->validationMessages([
                    'required' => 'Satuan level 1 wajib diisi.',
                ]),

            TextInput::make('jlh_lv_1')
                ->label('Jumlah Level 1')
                ->numeric()
                ->required()
                ->disabled()
                ->dehydrated()
                ->validationMessages([
                    'required' => 'Jumlah level 1 wajib diisi.',
                    'numeric' => 'Jumlah level 1 wajib berupa angka.',
                ]),

            Select::make('sat_lv_2')
                ->label('Satuan Level 2')
                ->options(Satuan::pluck('nama', 'id'))
                ->searchable()
                ->native(false)
                ->rules([
                    fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                        $sat1 = $get('sat_lv_1');
                        $sat3 = $get('sat_lv_3');
                        $jlh2 = $get('jlh_lv_2');

                        $hasValue = !empty($value);
                        $hasJlh2 = !empty($jlh2);
                        
                        if ($hasValue && !$hasJlh2) {
                            $fail('Jumlah Level 2 wajib diisi jika Satuan Level 2 dipilih.');
                            return;
                        }
                        
                        if (!$hasValue && $hasJlh2) {
                            $fail('Satuan Level 2 wajib dipilih jika Jumlah Level 2 diisi.');
                            return;
                        }

                        if ($value && $value == $sat1) {
                            $fail('Satuan Level 2 tidak boleh sama dengan Level 1.');
                            return;
                        }

                        if ($value && $sat3 && $value == $sat3) {
                            $fail('Satuan Level 2 tidak boleh sama dengan Level 3.');
                        }
                    },
                ]),

            TextInput::make('jlh_lv_2')
                ->label('Jumlah Level 2')
                ->numeric()
                ->minValue(0)
                ->rules([
                    fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                        $sat2 = $get('sat_lv_2');

                        if ($value < 0) {
                            $fail('Jumlah Level 2 tidak boleh negatif.');
                            return;
                        }

                        $hasValue = !empty($value) && $value > 0;
                        $hasSat2 = !empty($sat2);
                        
                        if ($hasValue && !$hasSat2) {
                            $fail('Satuan Level 2 wajib dipilih jika Jumlah Level 2 diisi.');
                            return;
                        }
                        
                        if (!$hasValue && $hasSat2) {
                            $fail('Jumlah Level 2 wajib diisi jika Satuan Level 2 dipilih.');
                        }
                    },
                ])
                ->validationMessages([
                    'numeric' => 'Jumlah level 2 wajib berupa angka.',
                ]),

            Select::make('sat_lv_3')
                ->label('Satuan Level 3')
                ->options(Satuan::pluck('nama', 'id'))
                ->searchable()
                ->native(false)
                ->rules([
                    fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                        $sat1 = $get('sat_lv_1');
                        $sat2 = $get('sat_lv_2');
                        $jlh2 = $get('jlh_lv_2');
                        $jlh3 = $get('jlh_lv_3');

                        $hasSat2 = !empty($sat2);
                        $hasJlh2 = !empty($jlh2) && $jlh2 > 0;
                        $hasValue = !empty($value);
                        $hasJlh3 = !empty($jlh3) && $jlh3 > 0;

                        if (($hasValue || $hasJlh3) && (!$hasSat2 || !$hasJlh2)) {
                            $fail('Level 2 harus diisi lengkap sebelum mengisi Level 3.');
                            return;
                        }

                        if ($hasValue && !$hasJlh3) {
                            $fail('Jumlah Level 3 wajib diisi jika Satuan Level 3 dipilih.');
                            return;
                        }

                        if (!$hasValue && $hasJlh3) {
                            $fail('Satuan Level 3 wajib dipilih jika Jumlah Level 3 diisi.');
                            return;
                        }

                        if ($value && $value == $sat1) {
                            $fail('Satuan Level 3 tidak boleh sama dengan Level 1.');
                            return;
                        }

                        if ($value && $sat2 && $value == $sat2) {
                            $fail('Satuan Level 3 tidak boleh sama dengan Level 2.');
                        }
                    },
                ]),

            TextInput::make('jlh_lv_3')
                ->label('Jumlah Level 3')
                ->numeric()
                ->minValue(0)
                ->rules([
                    fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                        $sat2 = $get('sat_lv_2');
                        $jlh2 = $get('jlh_lv_2');
                        $sat3 = $get('sat_lv_3');

                        if ($value < 0) {
                            $fail('Jumlah Level 3 tidak boleh negatif.');
                            return;
                        }

                        $hasSat2 = !empty($sat2);
                        $hasJlh2 = !empty($jlh2) && $jlh2 > 0;
                        $hasValue = !empty($value) && $value > 0;
                        $hasSat3 = !empty($sat3);

                        if (($hasValue || $hasSat3) && (!$hasSat2 || !$hasJlh2)) {
                            $fail('Level 2 harus diisi lengkap sebelum mengisi Level 3.');
                            return;
                        }

                        if ($hasValue && !$hasSat3) {
                            $fail('Satuan Level 3 wajib dipilih jika Jumlah Level 3 diisi.');
                            return;
                        }

                        if (!$hasValue && $hasSat3) {
                            $fail('Jumlah Level 3 wajib diisi jika Satuan Level 3 dipilih.');
                        }
                    },
                ])
                ->validationMessages([
                    'numeric' => 'Jumlah level 3 wajib berupa angka.',
                ]),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('barang_id')
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->width('70px')
                    ->alignCenter(),

                TextColumn::make('barang.nama')
                    ->label('Nama Barang')
                    ->formatStateUsing(fn ($record) =>
                        "{$record->barang->nama} (Merek: " . ($record->barang->merek->nama ?? 'Tanpa Merek') . ")"
                    )
                    ->searchable(query: function ($query, $search) {
                        $query->whereHas('barang', function ($barangQuery) use ($search) {
                            $barangQuery->where('nama', 'like', "%{$search}%")
                                ->orWhereHas('merek', function ($merekQuery) use ($search) {
                                    $merekQuery->where('nama', 'like', "%{$search}%");
                                });
                        });
                    })
                    ->sortable(query: function ($query, $direction) {
                        $query->orderBy(
                            Barang::select('nama')
                                ->whereColumn('barangs.id', 'konversi_satuans.barang_id')
                                ->limit(1),
                            $direction
                        );
                    }),


                TextColumn::make('satuan_1.nama')
                    ->label('Satuan Lv.1'),

                TextColumn::make('jlh_lv_1')
                    ->label('Jlh lv.1')
                    ->numeric()
                    ->alignCenter(),

                TextColumn::make('satuan_2.nama')
                    ->label('Satuan Lv.2'),

                TextColumn::make('jlh_lv_2')
                    ->label('Jlh lv.2')
                    ->alignCenter(),

                TextColumn::make('satuan_3.nama')
                    ->label('Satuan Lv.3'),

                TextColumn::make('jlh_lv_3')
                    ->label('Jlh lv.3')
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Ubah Konversi Satuan')
                    ->modalWidth('2xl'),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageKonversiSatuans::route('/'),
        ];
    }
}
