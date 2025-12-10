<?php

namespace App\Services;

use App\Models\Konversi;
use Illuminate\Support\Collection;

class StockConverterService
{
    /**
     * Konversi jumlah dari satuan tertentu ke satuan terkecil
     */
    public function convertToSmallestUnit(int $barangId, int $satuanId, float $jumlah): float
    {
        $konversiList = $this->getKonversiList($barangId);
        $selectedKonversi = $this->getSelectedKonversi($konversiList, $satuanId);

        return $this->calculateConversion($konversiList, $selectedKonversi, $jumlah);
    }

    /**
     * Untuk debugging perhitungan konversi
     */
    public function debugConversion(int $barangId, int $satuanId, float $jumlah): array
    {
        $konversiList = $this->getKonversiList($barangId);
        $selectedKonversi = $this->getSelectedKonversi($konversiList, $satuanId);

        return $this->calculateWithDebug($konversiList, $selectedKonversi, $jumlah);
    }

    /**
     * Format stok ke semua satuan: 
     * contoh: "0 Box / 2 Strip / 25 Tablet" atau "0 Lusin / 0 Box / 2 Strip / 25 Tablet" atau "5 Tablet"
     */
    public function formatAllUnits($barang, float $jumlahTerkecil): string
    {
        try {
            // Pastikan sudah eager-loaded
            $konversiList = $barang->konversis;

            if ($konversiList->isEmpty()) {
                return "{$jumlahTerkecil} Unit";
            }

            $resultParts = [];

            foreach ($konversiList as $konversi) {
                if ($konversi->urutan == 1) {
                    $jumlahUnit = $jumlahTerkecil;
                } else {
                    $faktor = 1;
                    for ($i = $konversi->urutan; $i >= 2; $i--) {
                        $current = $konversiList->firstWhere('urutan', $i);
                        if ($current) {
                            $faktor *= $current->konversi_ke_satuan_terkecil;
                        }
                    }
                    $jumlahUnit = floor($jumlahTerkecil / $faktor);
                }

                $resultParts[] = (int)$jumlahUnit . ' ' . $konversi->satuan->nama;
            }

            return implode(' / ', $resultParts);
        }
        catch (\Exception $e) {
            return "{$jumlahTerkecil} Unit";
        }
    }

    private function getKonversiList(int $barangId): Collection
    {
        $konversiList = Konversi::where('barang_id', $barangId)
            ->with('satuan')
            ->orderBy('urutan')
            ->get();

        if ($konversiList->isEmpty()) {
            throw new \InvalidArgumentException("Tidak ada data konversi untuk barang ini");
        }

        return $konversiList;
    }

    private function getSelectedKonversi(Collection $konversiList, int $satuanId): Konversi
    {
        $selectedKonversi = $konversiList->firstWhere('satuan_id', $satuanId);
        
        if (!$selectedKonversi) {
            throw new \InvalidArgumentException("Satuan tidak valid untuk barang ini");
        }

        return $selectedKonversi;
    }

    private function calculateConversion(Collection $konversiList, Konversi $selectedKonversi, float $jumlah): float
    {
        // Jika sudah satuan terkecil (urutan 1)
        if ($selectedKonversi->urutan === 1) {
            return $jumlah;
        }

        $result = $jumlah;
        
        // Kalikan dengan semua konversi dari urutan yang dipilih sampai urutan 2
        for ($currentUrutan = $selectedKonversi->urutan; $currentUrutan >= 2; $currentUrutan--) {
            $konversi = $konversiList->firstWhere('urutan', $currentUrutan);
            $result *= $konversi->konversi_ke_satuan_terkecil;
        }

        return $result;
    }

    private function calculateWithDebug(Collection $konversiList, Konversi $selectedKonversi, float $jumlah): array
    {
        $debug = [
            'input' => [
                'jumlah' => $jumlah,
                'satuan' => $selectedKonversi->satuan->nama,
                'urutan' => $selectedKonversi->urutan,
            ],
            'calculation_steps' => [],
            'result' => 0
        ];

        $result = $jumlah;
        
        for ($currentUrutan = $selectedKonversi->urutan; $currentUrutan >= 2; $currentUrutan--) {
            $konversi = $konversiList->firstWhere('urutan', $currentUrutan);
            $previousResult = $result;
            $result *= $konversi->konversi_ke_satuan_terkecil;

            $debug['calculation_steps'][] = [
                'from_urutan' => $currentUrutan,
                'from_satuan' => $konversi->satuan->nama,
                'conversion_factor' => $konversi->konversi_ke_satuan_terkecil,
                'before' => $previousResult,
                'after' => $result,
            ];
        }

        $smallestUnit = $konversiList->first()->satuan->nama;
        $debug['result'] = [
            'value' => $result,
            'satuan' => $smallestUnit,
        ];

        return $debug;
    }
}