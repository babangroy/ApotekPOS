<?php

namespace App\Filament\Clusters\Master\Resources\Konversis;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Konversis\Pages\ManageKonversis;
use App\Models\Barang;
use App\Models\Konversi;
use App\Models\Satuan;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class KonversiResource extends Resource
{
    protected static ?string $model = Konversi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'barang_id';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('barang_id')
                    ->label('Nama Barang')
                    ->options(Barang::query()->pluck('nama', 'id'))
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->required()
                    ->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (!$state) return;

                        $barang = Barang::find($state);

                        if (!$barang) return;

                        $set('konversi_items', [
                            [
                                'satuan_id' => $barang->satuan_id,
                                'konversi_ke_satuan_terkecil' => 1,
                                'is_default' => true,
                            ]
                        ]);
                    })
                    ->disabled(fn ($operation) => $operation === 'edit')
                    ->dehydrated(true),

                Repeater::make('konversi_items')
                    ->label('Data Konversi Satuan')
                    ->columnSpanFull()
                    ->table([
                        TableColumn::make('Satuan')
                            ->width('250px'),
                        TableColumn::make('Jumlah'),
                        TableColumn::make('Satuan utama?')->alignCenter(),
                    ])
                    ->schema([
                        Select::make('satuan_id')
                            ->options(Satuan::query()->pluck('nama', 'id'))
                            ->preload()
                            ->required()
                            ->validationMessages([
                                'required' => 'Satuan harus di pilih'
                            ]),

                        TextInput::make('konversi_ke_satuan_terkecil')
                            ->integer()
                            ->required()
                            ->default(1)
                            ->minValue(1)
                            ->validationMessages([
                                'required' => 'Jumlah konversi harus di isi',
                                'minValue' => 'Jumlah tidak bolen kurang dari 1'
                            ]),

                        Toggle::make('is_default')
                            // ->default(false)
                            ->distinct()
                            ->validationMessages([
                                'distinct' => 'Pilih hanya 1 satuan utama'
                            ]),
                    ])
                    ->defaultItems(1)
                    ->addActionLabel('Tambah Konversi')
                    ->minItems(1)
                    ->validationMessages([
                        'min' => 'Konversi tidak boleh kosong',
                        'distinct' => 'Pilih hanya 1 satuan utama'
                    ])
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
                    ->numeric()
                    ->sortable(),

                TextColumn::make('satuan.nama')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('konversi_ke_satuan_terkecil')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('is_default')
                    ->label('Satuan utama?')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('3xl')
                    ->using(function (Konversi $record, array $data) {
                        Konversi::where('barang_id', $record->barang_id)->delete();

                        $barangId = $data['barang_id'];
                        $konversiItems = $data['konversi_items'] ?? [];

                        foreach ($konversiItems as $index => $item) {
                            Konversi::create([
                                'barang_id' => $barangId,
                                'satuan_id' => $item['satuan_id'],
                                'konversi_ke_satuan_terkecil' => $item['konversi_ke_satuan_terkecil'],
                                'is_default' => $item['is_default'] ?? false,
                                'urutan' => $index + 1,
                            ]);
                        }

                        return $record;
                    })
                    ->fillForm(function (Konversi $record) {
                        $allKonversi = Konversi::where('barang_id', $record->barang_id)->get();

                        $konversiItems = $allKonversi->map(function ($item) {
                            return [
                                'satuan_id' => $item->satuan_id,
                                'konversi_ke_satuan_terkecil' => $item->konversi_ke_satuan_terkecil,
                                'is_default' => $item->is_default,
                            ];
                        })->toArray();

                        return [
                            'barang_id' => $record->barang_id,
                            'konversi_items' => $konversiItems,
                        ];
                    }),

                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageKonversis::route('/'),
        ];
    }
}
