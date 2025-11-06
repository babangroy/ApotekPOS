<?php

namespace App\Filament\Clusters\Master\Resources\Jenis;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Jenis\Pages\ManageJenis;
use App\Models\Jenis;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class JenisResource extends Resource
{
    protected static ?string $model = Jenis::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static string | UnitEnum | null $navigationGroup = 'Referensi';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Jenis')
                    ->required()
                    ->unique(ignoreRecord:true)
                    ->validationMessages([
                        'required' => 'Nama jenis wajib di isi',
                        'unique' => 'Nama jenis sudah ada',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->width('70px')
                    ->alignCenter(),

                TextColumn::make('nama')
                    ->label('Jenis')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('md'),
                DeleteAction::make()
                    ->before(function (Jenis $record, DeleteAction $action) {
                        if ($record->barangs()->exists()) {
                            Notification::make()
                                ->title('Error')
                                ->body('Jenis ini masih digunakan pada tabel Barang.')
                                ->danger()
                                ->duration(4000)
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
            'index' => ManageJenis::route('/'),
        ];
    }
}
