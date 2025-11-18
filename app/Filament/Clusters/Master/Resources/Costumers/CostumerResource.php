<?php

namespace App\Filament\Clusters\Master\Resources\Costumers;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Costumers\Pages\ManageCostumers;
use App\Models\Costumer;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class CostumerResource extends Resource
{
    protected static ?string $slug = 'pelanggan';

    protected static ?string $model = Costumer::class;

    protected static ?string $modelLabel = 'Pelanggan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string | UnitEnum | null $navigationGroup = 'Pelanggan';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'jenis';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('jenis')
                    ->label('Jenis Pelanggan')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->validationMessages([
                        'unique' => 'Jenis pelanggan sudah ada',
                        'required' => 'Jenis pelanggan harus di isi',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('jenis')
            ->columns([
                TextColumn::make('#')
                    ->rowIndex()
                    ->width('70px')
                    ->alignCenter(),

                TextColumn::make('jenis')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('md')
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCostumers::route('/'),
        ];
    }
}
