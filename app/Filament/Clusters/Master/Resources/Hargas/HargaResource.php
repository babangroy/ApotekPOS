<?php

namespace App\Filament\Clusters\Master\Resources\Hargas;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Hargas\Pages\ManageHargas;
use App\Models\Barang;
use App\Models\Harga;
use App\Models\Konversi;
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
                    ->options(
                        Barang::whereHas('konversis')
                            ->with('merek')
                            ->orderBy('nama')
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn ($barang) => [
                                $barang->id => $barang->nama . ' - ' . ($barang->merek->nama ?? 'Tanpa Merek')
                            ])
                    )
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return Barang::whereHas('konversis')
                            ->with('merek')
                            ->where('nama', 'like', "%{$search}%")
                            ->orWhereHas('merek', function ($query) use ($search) {
                                $query->where('nama', 'like', "%{$search}%");
                            })
                            ->orderBy('nama')
                            ->get()
                            ->mapWithKeys(fn ($barang) => [
                                $barang->id => $barang->nama . ' - ' . ($barang->merek->nama ?? 'Tanpa Merek')
                            ]);
                    })
                    ->preload()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('harga', []);
                        
                        if ($state) {
                            $konversi = Konversi::with('satuan')
                                ->where('barang_id', $state)
                                ->get();
                            
                            $hargaData = [];
                            
                            foreach ($konversi as $item) {
                                $hargaData[] = [
                                    'satuan_id' => $item->satuan_id
                                ];
                            }
                            
                            $set('harga', $hargaData);
                        }
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
                                TableColumn::make('Satuan')
                                    ->width('150px'),
                                TableColumn::make('Harga Umum'),
                                TableColumn::make('Harga Bidan'),
                            ])
                            ->schema([
                                Select::make('satuan_id')
                                    ->relationship(name:'satuan', titleAttribute:'nama')
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
                TextColumn::make('barang_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('batch_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('harga_umum')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('harga_bidan')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_override')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
