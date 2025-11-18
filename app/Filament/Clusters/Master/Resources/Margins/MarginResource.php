<?php

namespace App\Filament\Clusters\Master\Resources\Margins;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Margins\Pages\ManageMargins;
use App\Models\Margin;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class MarginResource extends Resource
{
    protected static ?string $model = Margin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPercentBadge;

    protected static string | UnitEnum | null $navigationGroup = 'Harga';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'margin';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('costumer_id')
                    ->label('Jenis Pelanggan')
                    ->relationship(name:'costumer', titleAttribute:'jenis')
                    ->native(false)
                    ->required()
                    ->unique(ignoreRecord:true)
                    ->validationMessages([
                        'required' => 'Jenis pelanggan harus dipilih',
                        'unique' => 'Jenis pelanggan sudah ada'
                    ])
                    ->columnSpanFull(),

                TextInput::make('margin')
                    ->label('Margin')
                    ->suffix('%')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->validationMessages([
                        'required' => 'Margin harus di isi',
                        'numeric' => 'Margin harus berupa angka',
                        'min' => 'Margin tidak boleh dibawah 1%'
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('margin')
            ->columns([
                TextColumn::make('#')
                    ->rowIndex()
                    ->width('70px')
                    ->alignCenter(),

                TextColumn::make('costumer.jenis')
                    ->label('Jenis Pelanggan'),

                TextColumn::make('margin')
                    ->numeric()
                    ->suffix('%'),
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
            'index' => ManageMargins::route('/'),
        ];
    }
}
