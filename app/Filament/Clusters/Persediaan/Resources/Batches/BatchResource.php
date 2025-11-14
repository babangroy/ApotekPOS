<?php

namespace App\Filament\Clusters\Persediaan\Resources\Batches;

use App\Filament\Clusters\Persediaan\PersediaanCluster;
use App\Filament\Clusters\Persediaan\Resources\Batches\Pages\ManageBatches;
use App\Models\Batch;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Label;

class BatchResource extends Resource
{
    protected static ?string $model = Batch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = PersediaanCluster::class;

    protected static ?string $recordTitleAttribute = 'no_batch';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no_batch'),
                TextInput::make('barang_id')
                    ->required()
                    ->numeric(),
                Select::make('sumber')
                    ->options(['Pembelian' => 'Pembelian', 'Stok Awal' => 'Stok awal'])
                    ->required(),
                TextInput::make('pembelian_id')
                    ->numeric(),
                TextInput::make('supplier_id')
                    ->numeric(),
                DatePicker::make('tgl_kadaluarsa')
                    ->required(),
                TextInput::make('jumlah')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('jlh_tersedia')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('harga_beli_satuan')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('status')
                    ->options(['Tersedia' => 'Tersedia', 'Habis' => 'Habis', 'Kadaluarsa' => 'Kadaluarsa', 'Rusak' => 'Rusak'])
                    ->default('Tersedia')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('no_batch')
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->width('70px'),

                TextColumn::make('barang.nama')
                    ->label('Nama Barang')
                    ->sortable()
                    ->searchable(),

                // TextColumn::make('no_batch')
                //     ->searchable(),

                // TextColumn::make('tgl_kadaluarsa')
                //     ->label('Tanggal Exp')
                //     ->date('d M Y')
                //     ->sortable(),

                TextColumn::make('jlh_tersedia')
                    ->label('Stok')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
                // DeleteAction::make(),
            ])
            ->defaultSort('barang.nama', 'asc');
    }

public static function getEloquentQuery(): Builder
{
    $latestBatchPerBarang = DB::table('batches')
        ->select(DB::raw('MAX(id) as id'))
        ->where('status', 'Tersedia')
        ->groupBy('barang_id');

    return parent::getEloquentQuery()
        ->select(
            'batches.*',
            DB::raw('(SELECT SUM(b2.jlh_tersedia) 
                    FROM batches b2 
                    WHERE b2.barang_id = batches.barang_id 
                        AND b2.status = "Tersedia") as total_jlh_tersedia')
        )
        ->whereIn('batches.id', $latestBatchPerBarang);
}

    public static function getPages(): array
    {
        return [
            'index' => ManageBatches::route('/'),
        ];
    }
}
