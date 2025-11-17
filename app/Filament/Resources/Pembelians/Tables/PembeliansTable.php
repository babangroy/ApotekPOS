<?php

namespace App\Filament\Resources\Pembelians\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PembeliansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->width('70px')
                    ->alignCenter(),

                TextColumn::make('kode')
                    ->label('Kode Pembelian')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('no_faktur')
                    ->label('No Faktur')
                    ->searchable(),

                TextColumn::make('supplier.nama')
                    ->label('Supplier'),

                TextColumn::make('tgl_pembelian')
                    ->label('Tgl Pembelian')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status_pembayaran')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Lunas' => 'success',
                        'Dp' => 'gray',
                        'Belum Bayar' => 'danger',
                        'Sebagian' => 'warning',
                    }),

                TextColumn::make('tgl_jth_tempo')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR'),

                TextColumn::make('diskon')
                    ->label('Diskon')
                    ->money('IDR'),

                TextColumn::make('ppn')
                    ->label('PPN')
                    ->formatStateUsing(fn ($state) => $state . '%'),

                TextColumn::make('total_akhir')
                    ->label('Grand Total')
                    ->money('IDR'),

                TextColumn::make('creator.name')
                    ->label('Oleh')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ]);
    }
}
