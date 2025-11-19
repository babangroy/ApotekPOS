<?php

namespace App\Filament\Clusters\Master\Resources\Pabrikans;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Pabrikans\Pages\ManagePabrikans;
use App\Models\Pabrikan;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PabrikanResource extends Resource
{
    protected static ?string $model = Pabrikan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string | UnitEnum | null $navigationGroup = 'Referensi';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Pabrikan')
                    ->required()
                    ->unique()
                    ->validationMessages([
                        'required' => 'Nama pabrikan wajib di isi',
                        'unique' => 'Nama pabrikan sudah ada',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('#')
                    ->rowIndex()
                    ->width('70px')
                    ->alignCenter(),

                TextColumn::make('nama')
                    ->label('Nama Pabrikan')
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('nama', 'asc')
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
                    ->tooltip('Hapus data')
                    ->before(function (Pabrikan $record, DeleteAction $action) {
                        if ($record->barangs()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('Gagal')
                                ->body('Masih ada barang yang menggunakan pabrikan ' . $record->nama)
                                ->color(Color::Red)
                                ->send();
                            $action->cancel();
                            return;
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePabrikans::route('/'),
        ];
    }
}
