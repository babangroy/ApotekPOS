<?php

namespace App\Filament\Clusters\Master\Resources\Suppliers;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Suppliers\Pages\ManageSuppliers;
use App\Models\Supplier;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static string | UnitEnum | null $navigationGroup = 'Supplier';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Supplier')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama supplier wajib di isi'
                    ])
                    ->columnSpanFull(),

                Textarea::make('alamat')
                    ->label('Alamat Supplier')
                    ->columnSpanFull(),

                TextInput::make('no_telp')
                    ->label('No Telepon')
                    ->tel()
                    ->unique(ignoreRecord:true)
                    ->validationMessages([
                        'unique' => 'No telepon sudah terdaftar'
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->defaultSort('nama', 'asc')
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->width('70px')
                    ->alignCenter(),

                TextColumn::make('nama')
                    ->label('Nama Supplier')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('alamat')
                    ->label('Alamat Supplier')
                    ->limit(60),

                TextColumn::make('no_telp')
                    ->label('No Telepon'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Ubah data')
                    ->modalWidth('md'),
                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Hapus data'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSuppliers::route('/'),
        ];
    }
}
