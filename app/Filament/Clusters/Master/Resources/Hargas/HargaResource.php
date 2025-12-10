<?php

namespace App\Filament\Clusters\Master\Resources\Hargas;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Hargas\Pages\ManageHargas;
use App\Models\Batch;
use App\Models\Harga;
use App\Models\Konversi;
use App\Models\Satuan;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class HargaResource extends Resource
{
    protected static ?string $model = Harga::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Harga';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'barang_id';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('barang_id')
                    ->label('Nama Barang')
                    ->searchable()

                    ->options(function () {
                        return Batch::query()
                            ->selectRaw("
                                batches.barang_id,
                                CONCAT(
                                    barangs.nama, ' - ',
                                    COALESCE(mereks.nama, ''), 
                                    ' (No. Batch: ', batches.no_batch, ')'
                                ) AS label
                            ")
                            ->join('barangs', 'barangs.id', '=', 'batches.barang_id')
                            ->leftJoin('mereks', 'mereks.id', '=', 'barangs.merek_id')
                            ->limit(50)
                            ->orderBy('barangs.nama')
                            ->pluck('label', 'id');
                    })

                    ->getSearchResultsUsing(function (string $search) {
                        return Batch::query()
                            ->selectRaw("
                                batches.barang_id,
                                CONCAT(
                                    barangs.nama, ' - ',
                                    COALESCE(mereks.nama, ''), 
                                    ' (', batches.no_batch, ')'
                                ) AS label
                            ")
                            ->join('barangs', 'barangs.id', '=', 'batches.barang_id')
                            ->leftJoin('mereks', 'mereks.id', '=', 'barangs.merek_id')
                            ->where(function ($q) use ($search) {
                                $q->where('barangs.nama', 'like', "%{$search}%")
                                ->orWhere('mereks.nama', 'like', "%{$search}%")
                                ->orWhere('batches.no_batch', 'like', "%{$search}%");
                            })
                            ->limit(50)
                            ->pluck('label', 'id')
                            ->toArray();
                    })

                    ->getOptionLabelUsing(function ($value) {
                        return Batch::query()
                            ->selectRaw("
                                CONCAT(
                                    barangs.nama, ' - ',
                                    COALESCE(mereks.nama, ''), 
                                    ' (', batches.no_batch, ')'
                                ) AS label
                            ")
                            ->join('barangs', 'barangs.id', '=', 'batches.barang_id')
                            ->leftJoin('mereks', 'mereks.id', '=', 'barangs.merek_id')
                            ->where('batches.id', $value)
                            ->value('label');
                    })
                    ->preload()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {

                        $set('harga', []);

                        if (!$state) return;
                        $barangId = Batch::query()
                            ->join('barangs', 'barangs.id', '=', 'batches.barang_id')
                            ->where('batches.id', $state)
                            ->value('barangs.id');

                        if (!$barangId) return;

                        $konversi = Konversi::with('satuan')
                            ->where('barang_id', $barangId)
                            ->get();

                        $set('harga', $konversi->map(fn ($item) => [
                            'satuan_id' => $item->satuan_id,
                        ])->toArray());
                    })
                    ->validationMessages([
                        'required' => 'Nama barang harus dipilih',
                        'unique' => 'Barang ini sudah memiliki harga manual'
                    ])
                    ->columnSpanFull(),

                Grid::make()
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('harga')
                            ->label('Harga Umum')
                            ->table([
                                TableColumn::make('Satuan')->width('150px'),
                                TableColumn::make('Harga Umum'),
                                TableColumn::make('Harga Bidan'),
                            ])
                            ->schema([
                                Select::make('satuan_id')
                                    ->options(Satuan::query()->pluck('nama', 'id'))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),

                                TextInput::make('harga_umum')
                                    ->prefix('Rp')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->minValue(0),

                                TextInput::make('harga_bidan')
                                    ->prefix('Rp')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->minValue(0),
                            ])
                            ->reorderable(false)
                            ->deletable(false)
                            ->addable(false)
                            ->disabled(fn (Get $get): bool => !$get('barang_id')),

                        Toggle::make('is_active')
                            ->label('Harga aktif?')
                            ->onColor('info')
                            ->offColor('danger')
                            ->default(true)
                            ->disabled(fn (Get $get): bool => !$get('barang_id'))
                            ->helperText('Jika non-aktif, maka harga jual akan otomatis diperoleh dari margin'),
                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('barang_id')
            ->columns([
                TextColumn::make('barang.nama')
                    ->label('Nama Barang')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('batch.no_batch')
                    ->label('No. Batch'),

                TextColumn::make('harga_umum')
                    ->label('Harga Umum')
                    ->numeric()
                    ->money('IDR'),

                TextColumn::make('harga_bidan')
                    ->label('Harga Bidan')
                    ->numeric()
                    ->money('IDR'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('created_by')
                    ->label('Oleh')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHargas::route('/'),
        ];
    }
}
