<?php

namespace App\Filament\Clusters\Master\Resources\Konversis\Pages;

use App\Filament\Clusters\Master\Resources\Konversis\KonversiResource;
use App\Models\Konversi;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\DB;

class ManageKonversis extends ManageRecords
{
    protected static string $resource = KonversiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('2xl')
                ->using(function (array $data) {

                    DB::transaction(function () use ($data) {

                        $barangId = $data['barang_id'];
                        $items    = $data['konversi_items'] ?? [];
                        
                        Konversi::where('barang_id', $barangId)->delete();

                        foreach ($items as $i => $item) {
                            Konversi::create([
                                'barang_id' => $barangId,
                                'satuan_id' => $item['satuan_id'],
                                'konversi_ke_satuan_terkecil' => $item['konversi_ke_satuan_terkecil'],
                                'satuan_utama' => $item['satuan_utama'] ?? false,
                                'urutan' => $i + 1,
                            ]);
                        }
                    });

                    return null;
                }), 

        ];
    }
}
