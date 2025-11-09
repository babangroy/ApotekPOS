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
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class KonversiResource extends Resource
{
    protected static ?string $model = Konversi::class;

    protected static ?string $modelLabel = 'Konversi Satuan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static string | UnitEnum | null $navigationGroup = 'Produk';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'barang_id';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['barang.merek', 'satuan']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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

                    ->rule(function ($operation) {
                        return $operation === 'create'
                            ? 'unique:konversis,barang_id'
                            : null;
                    })
                    ->validationMessages([
                        'unique' => 'Konversi untuk barang tersebut sudah ada'
                    ])
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
                                'satuan_utama' => true,
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
                            ->searchable()
                            ->required()
                            ->distinct()
                            ->validationMessages([
                                'required' => 'Satuan harus di pilih',
                                'distinct' => 'Satuan tidak boleh sama'
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

                        Toggle::make('satuan_utama')
                            ->label('Satuan utama')
                            ->distinct()
                    ])
                    ->defaultItems(0)
                    ->reorderable(false)
                    ->addActionLabel('Tambah Konversi')
                    ->minItems(1)
                    ->validationMessages([
                        'min' => 'Konversi tidak boleh kosong',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('barang_id')
            ->columns([
                TextColumn::make('barang.nama')
                    ->label('Barang')
                    ->getStateUsing(function ($record) {
                        if (! $record->barang) {
                            return '-';
                        }

                        $nama = $record->barang->nama ?? '-';
                        $merek = $record->barang->merek->nama ?? '-';

                        return $nama . ' (' . $merek . ')';
                    })
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->whereHas('barang', function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%")
                            ->orWhereHas('merek', fn ($m) => $m->where('nama', 'like', "%{$search}%"));
                        });
                    }),

                TextColumn::make('satuan.nama')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('konversi_ke_satuan_terkecil')
                    ->numeric()
                    ->alignCenter(),

                IconColumn::make('satuan_utama')
                    ->label('Satuan utama?')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->groups([
                Group::make('barang.nama')
                ->label('Nama Barang')
                ->getTitleFromRecordUsing(function (Konversi $record) {
                    $namaBarang = $record->barang->nama ?? '-';
                    $merek = $record->barang->merek->nama ?? '-';

                    return "{$namaBarang}, Merek: {$merek}";
                })
                    ->collapsible(),
            ])
            ->defaultGroup('barang.nama')
            ->collapsedGroupsByDefault()
            ->groupingSettingsHidden()

            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('3xl')
                    ->using(function (Konversi $record, array $data) {
                        return DB::transaction(function () use ($data, $record) {
                            $barangId = $data['barang_id'];
                            $konversiItems = $data['konversi_items'] ?? [];

                            $existing = Konversi::where('barang_id', $barangId)->get();
                            $updatedIds = [];

                            foreach ($konversiItems as $index => $item) {
                                $existingRecord = $existing->firstWhere('satuan_id', $item['satuan_id']);

                                $payload = [
                                    'barang_id' => $barangId,
                                    'satuan_id' => $item['satuan_id'],
                                    'konversi_ke_satuan_terkecil' => $item['konversi_ke_satuan_terkecil'],
                                    'satuan_utama' => $item['satuan_utama'] ?? false,
                                    'urutan' => $index + 1,
                                ];

                                if ($existingRecord) {
                                    $existingRecord->update($payload);
                                    $updatedIds[] = $existingRecord->id;
                                } else {
                                    $new = Konversi::create($payload);
                                    $updatedIds[] = $new->id;
                                }
                            }

                            Konversi::where('barang_id', $barangId)
                                ->whereNotIn('id', $updatedIds)
                                ->delete();

                            return $record->refresh();
                        });
                    })
                    ->fillForm(function (Konversi $record) {
                        $konversi = Konversi::where('barang_id', $record->barang_id)
                            ->orderBy('urutan')
                            ->get(['satuan_id', 'konversi_ke_satuan_terkecil', 'satuan_utama']);

                        return [
                            'barang_id' => $record->barang_id,
                            'konversi_items' => $konversi->toArray(),
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
