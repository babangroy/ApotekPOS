<?php

namespace App\Filament\Clusters\Master\Resources\Mereks;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Mereks\Pages\ManageMereks;
use App\Models\Merek;
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

class MerekResource extends Resource
{
    protected static ?string $model = Merek::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmarkSquare;

    protected static string | UnitEnum | null $navigationGroup = 'Referensi';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Merek')
                    ->unique(ignoreRecord:true)
                    ->required()
                    ->validationMessages([
                        'unique' => 'Nama merek sudah ada',
                        'required' =>'Nama kategori wajib di isi'
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
                    ->label('Merek')
                    ->searchable()
                    ->sortable(),
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
                    ->tooltip('Hapus data')
                    ->before(function (Merek $record, DeleteAction $action) {
                        if ($record->barangs()->exists()) {
                            Notification::make()
                                ->title('Error')
                                ->body('Merek ini masih digunakan pada tabel Barang.')
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
            'index' => ManageMereks::route('/'),
        ];
    }
}
