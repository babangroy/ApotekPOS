<?php

namespace App\Filament\Clusters\Master\Resources\Satuans;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Satuans\Pages\ManageSatuans;
use App\Models\Satuan;
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

class SatuanResource extends Resource
{
    protected static ?string $model = Satuan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string | UnitEnum | null $navigationGroup = 'Referensi';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Kategori')
                    ->unique(ignoreRecord:true)
                    ->required()
                    ->validationMessages([
                        'unique' => 'Nama kategori sudah ada',
                        'required' => 'Nama kategori wajib di isi',
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
                    ->label('Nama Satuan')
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
                    ->before(function (Satuan $record, DeleteAction $action) {
                        if ($record->konversis()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('Gagal')
                                ->body('Masih ada konversi barang yang menggunakan satuan ' . $record->nama)
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
            'index' => ManageSatuans::route('/'),
        ];
    }
}
