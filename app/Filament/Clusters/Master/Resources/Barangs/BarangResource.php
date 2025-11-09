<?php

namespace App\Filament\Clusters\Master\Resources\Barangs;

use App\Filament\Clusters\Master\MasterCluster;
use App\Filament\Clusters\Master\Resources\Barangs\Pages\ManageBarangs;
use App\Models\Barang;
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

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static string | UnitEnum | null $navigationGroup = 'Produk';

    protected static ?string $cluster = MasterCluster::class;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('barcode')
                    ->label('Barcode Barang')
                    ->unique()
                    ->validationMessages([
                        'unique' => 'Barcode barang sudah ada'
                    ])
                    ->columnSpan(1),

                TextInput::make('nama')
                    ->label('Nama Barang')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama barang wajib di isi'
                    ])
                    ->columnSpan(1),

                Select::make('jenis_id')
                    ->label('Jenis')
                    ->relationship(name:'jenis', titleAttribute:'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Jenis barang harus di pilih'
                    ])
                    ->native(false)
                    ->columnSpan(1)
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->label('Nama Jenis')
                            ->required()
                            ->unique()
                            ->validationMessages([
                                'required' => 'Nama jenis wajib di isi',
                                'unique' => 'Nama jenis sudah ada',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->createOptionAction(fn ($action) => $action->modalWidth('md')->modalHeading('Buat Jenis')),

                Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship(name:'kategori', titleAttribute:'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Kategori barang harus di pilih'
                    ])
                    ->native(false)
                    ->columnSpan(1)
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->label('Nama Kategori')
                            ->required()
                            ->unique()
                            ->validationMessages([
                                'required' => 'Nama Kategori wajib di isi',
                                'unique' => 'Nama Kategori sudah ada',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->createOptionAction(fn ($action) => $action->modalWidth('md')->modalHeading('Buat Kategori')),

                Select::make('merek_id')
                    ->label('Merek')
                    ->relationship(name:'merek', titleAttribute:'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Merek barang harus di pilih'
                    ])
                    ->native(false)
                    ->columnSpan(1)
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->label('Nama Merek')
                            ->required()
                            ->unique()
                            ->validationMessages([
                                'required' => 'Nama Merek wajib di isi',
                                'unique' => 'Nama Merek sudah ada',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->createOptionAction(fn ($action) => $action->modalWidth('md')->modalHeading('Buat Merek')),

                Select::make('pabrikan_id')
                    ->label('Pabrikan')
                    ->relationship(name:'pabrikan', titleAttribute:'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Pabrikan barang harus di pilih'
                    ])
                    ->native(false)
                    ->columnSpan(1)
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->label('Nama Pabrikan')
                            ->required()
                            ->unique()
                            ->validationMessages([
                                'required' => 'Nama Pabrikan wajib di isi',
                                'unique' => 'Nama Pabrikan sudah ada',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->createOptionAction(fn ($action) => $action->modalWidth('md')->modalHeading('Buat Pabrikan')),

                Select::make('satuan_id')
                    ->label('Satuan Terkecil')
                    ->relationship(name:'satuan', titleAttribute:'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'Satuan terkecil barang harus di pilih'
                    ])
                    ->native(false)
                    ->columnSpan(1)
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->label('Nama Satuan')
                            ->required()
                            ->unique()
                            ->validationMessages([
                                'required' => 'Nama satuan wajib di isi',
                                'unique' => 'Nama satuan sudah ada',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->createOptionAction(fn ($action) => $action->modalWidth('md')->modalHeading('Buat Satuan')),                    
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

                TextColumn::make('kode')
                    ->label('Kode Barang')
                    ->searchable()
                    ->alignCenter(),

                TextColumn::make('barcode')
                    ->label('Barcode Barang')
                    ->searchable(),

                TextColumn::make('nama')
                    ->label('Nama Barang')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('jenis.nama')
                    ->label('Jenis'),

                TextColumn::make('kategori.nama')
                    ->label('Kategori'),

                TextColumn::make('merek.nama')
                    ->label('Merek'),

                TextColumn::make('pabrikan.nama')
                    ->label('Pabrikan'),

                TextColumn::make('satuan.nama')
                    ->label('Satuan Terkecil'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('3xl'),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBarangs::route('/'),
        ];
    }
}
