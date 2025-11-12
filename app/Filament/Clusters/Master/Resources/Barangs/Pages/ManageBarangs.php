<?php

namespace App\Filament\Clusters\Master\Resources\Barangs\Pages;

use App\Filament\Clusters\Master\Resources\Barangs\BarangResource;
use App\Models\Konversi;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ManageBarangs extends ManageRecords
{
    protected static string $resource = BarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('3xl')
                ->using(function (array $data, string $model): Model {
                    return DB::transaction(function () use ($data, $model) {
                        $record = $model::create($data);

                        Konversi::create([
                            'barang_id' => $record->id,
                            'satuan_id' => $record->satuan_id,
                            'konversi_ke_satuan_terkecil' => 1,
                        ]);

                        return $record;
                    });
                })
        ];
    }
}
