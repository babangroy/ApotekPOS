<?php

namespace App\Filament\Clusters\Master\Resources\Hargas;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Hargas\Pages\ManageHargas;
use App\Models\Harga;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
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
                    ->relationship(name:'barangs', titleAttribute:'nama')
                    ->searchable()
                    ->preload()
                    ->unique(ignoreRecord:true)
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama barang harus dipilih',
                        'unique' => 'Barang ini sudah memiliki harga manual'
                    ]),

                TextInput::make('harga_umum')
                    ->label('Harga Umum')
                    ->prefix('Rp')
                    ->required()
                    ->numeric()
                    ->minValue(1),

                TextInput::make('harga_bidan')
                    ->required()
                    ->numeric()
                    ->default(0.0),

                Toggle::make('is_override')
                    ->required(),

                Toggle::make('is_active')
                    ->required(),

                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
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
