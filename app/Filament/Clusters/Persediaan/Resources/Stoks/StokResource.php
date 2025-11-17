<?php

namespace App\Filament\Clusters\Persediaan\Resources\Stoks;

use App\Filament\Clusters\Persediaan\PersediaanCluster;
use App\Filament\Clusters\Persediaan\Resources\Stoks\Pages\ManageStoks;
use App\Models\Batch;
use App\Services\StockConverterService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class StokResource extends Resource
{
    protected static ?string $slug = 'stok-barang';

    protected static ?string $model = Batch::class;

    protected static ?string $modelLabel = 'Stok Per Barang';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static string | UnitEnum | null $navigationGroup = 'Stok Barang';

    protected static ?string $cluster = PersediaanCluster::class;

    protected static ?string $recordTitleAttribute = 'barang_id';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {

                $subMin = DB::table('batches')
                    ->selectRaw('MIN(id) AS id, barang_id')
                    ->groupBy('barang_id');

                $subSum = DB::table('batches')
                    ->selectRaw('barang_id, SUM(jlh_tersedia) AS total_stok')
                    ->groupBy('barang_id');

                return $query
                    ->joinSub($subMin, 'm', 'batches.id', '=', 'm.id')
                    ->leftJoinSub($subSum, 's', 'batches.barang_id', '=', 's.barang_id')
                    ->with(['barang'])
                    ->select('batches.*', 's.total_stok');
            })
            ->defaultKeySort(false)
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->width('70px')
                    ->alignCenter(),

                TextColumn::make('barang.nama')
                    ->label('Nama Barang')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('total_stok')
                    ->label('Stok Tersedia')
                    ->formatStateUsing(function ($state, $record) {
                        $converter = app(StockConverterService::class);
                        return $converter->formatAllUnits($record->barang_id, $state);
                    }),
            ])
            ->defaultSort('barang.nama', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageStoks::route('/'),
        ];
    }
}
