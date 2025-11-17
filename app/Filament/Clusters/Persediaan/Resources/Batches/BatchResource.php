<?php

namespace App\Filament\Clusters\Persediaan\Resources\Batches;

use App\Filament\Clusters\Persediaan\PersediaanCluster;
use App\Filament\Clusters\Persediaan\Resources\Batches\Pages\ManageBatches;
use App\Models\Barang;
use App\Models\Batch;
use App\Models\Merek;
use App\Services\StockConverterService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class BatchResource extends Resource
{
    protected static ?string $slug = 'stok-batch';

    protected static ?string $model = Batch::class;

    protected static ?string $modelLabel = 'Stok Per Batch';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;
    
    protected static string | UnitEnum | null $navigationGroup = 'Stok Barang';

    protected static ?string $cluster = PersediaanCluster::class;

    protected static ?string $recordTitleAttribute = 'no_batch';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->with(['barang.merek', 'supplier']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->width('70px')
                    ->alignCenter(),

                TextColumn::make('barang.nama')
                    ->label('Nama Barang')
                    ->formatStateUsing(fn ($state, $record) => 
                        $state . ' - ' . $record->barang?->merek?->nama
                    )
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy(
                            Barang::select('nama')
                                ->whereColumn('id', 'batches.barang_id')
                                ->limit(1),
                            $direction
                        );
                    })
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->whereHas('barang', function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%")
                            ->orWhereHas('merek', function ($q2) use ($search) {
                                $q2->where('nama', 'like', "%{$search}%");
                            });
                        });
                    }),

                TextColumn::make('no_batch')
                    ->label('No Batch')
                    ->searchable(),

                TextColumn::make('supplier.nama')
                    ->label('Supplier'),

                TextColumn::make('tgl_kadaluarsa')
                    ->label('Tgl Expired')
                    ->date('d M Y')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('jlh_tersedia')
                    ->label('Stok Tersedia')
                    ->formatStateUsing(function ($state, $record) {
                        $converter = app(StockConverterService::class);
                        return $converter->formatAllUnits($record->barang_id, $state);
                    }),
                ])
                ->defaultSort(function (Builder $query): Builder {
                    return $query->orderBy(
                        Barang::select('nama')
                            ->whereColumn('id', 'batches.barang_id')
                            ->limit(1),
                        'asc'
                    );
                });
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBatches::route('/'),
        ];
    }
}
