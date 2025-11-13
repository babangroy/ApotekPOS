<?php

namespace App\Filament\Resources\Pembelians\Pages;

use App\Filament\Resources\Pembelians\PembelianResource;
use App\Models\Batch;
use App\Models\HistoriStok;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreatePembelian extends CreateRecord
{
    protected static string $resource = PembelianResource::class;

    protected static bool $canCreateAnother = false;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {

            // ========== Generate Kode Otomatis ==========
            $today = Carbon::now()->format('dmY');
            $prefix = 'PBL-' . $today . '-';

            $lastKode = Pembelian::where('kode', 'like', $prefix . '%')
                ->latest('kode')
                ->value('kode');

            $newNumber = $lastKode
                ? str_pad(((int) Str::substr($lastKode, -4)) + 1, 4, '0', STR_PAD_LEFT)
                : '0001';
 
            $data['kode'] = $prefix . $newNumber;

            // ========== Simpan Data Pembelian ==========
            $pembelian = Pembelian::create([
                'kode' => $data['kode'],
                'no_faktur' => $data['no_faktur'] ?? null,
                'supplier_id' => $data['supplier_id'],
                'tgl_pembelian' => $data['tgl_pembelian'],
                'tgl_jth_tempo' => $data['tgl_jth_tempo'] ?? null,
                'status_pembayaran' => $data['status_pembayaran'],
                'subtotal' => $data['subtotal'],
                'diskon' => $data['diskon'] ?? 0,
                'ppn' => $data['ppn'] ?? 0,
                'total_akhir' => $data['total_akhir'],
                'catatan' => $data['catatan'] ?? null,
                'oleh' => Auth::id(),
            ]);

            // ========== Hitung Proporsi Diskon & PPN per Item ==========
            $details = $data['pembelian_details'];
            $totalSubTotal = collect($details)->sum(fn ($d) => $d['jumlah'] * $d['harga']);
            $totalDiskon = $data['diskon'] ?? 0;
            $totalPPN = $data['ppn'] ?? 0;

            foreach ($details as $detail) {
                $subTotal = $detail['jumlah'] * $detail['harga'];

                // Proporsi diskon & PPN per item berdasarkan total subtotal
                $diskonPerItem = $totalSubTotal > 0 ? ($subTotal / $totalSubTotal) * $totalDiskon : 0;
                $ppnPerItem = ($subTotal - $diskonPerItem) * ($totalPPN / 100);
                $totalAkhir = $subTotal - $diskonPerItem + $ppnPerItem;

                // Simpan detail pembelian
                $detailRecord = PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'barang_id' => $detail['barang_id'],
                    'satuan_id' => $detail['satuan_id'],
                    'jumlah' => $detail['jumlah'],
                    'harga' => $detail['harga'],
                    'sub_total' => $subTotal,
                    'diskon' => $diskonPerItem,
                    'ppn' => $ppnPerItem,
                    'total_akhir' => $totalAkhir,
                ]);

                // Simpan batch baru
                $batch = Batch::create([
                    'no_batch' => $detail['no_batch'] ?? null,
                    'barang_id' => $detail['barang_id'],
                    'sumber' => 'Pembelian',
                    'pembelian_id' => $pembelian->id,
                    'supplier_id' => $pembelian->supplier_id,
                    'tgl_kadaluarsa' => $detail['tgl_kadaluarsa'] ?? null,
                    'jumlah' => $detail['jumlah'],
                    'jlh_tersedia' => $detail['jumlah'],
                    'harga_beli_satuan' => $detail['harga'],
                ]);

                // Simpan histori stok
                $lastHistori = HistoriStok::where('barang_id', $detail['barang_id'])
                    ->latest('id')
                    ->first();

                $jlhSebelum = $lastHistori?->jlh_setelah ?? 0;
                $jlhPerubahan = $detail['jumlah'];
                $jlhSetelah = $jlhSebelum + $jlhPerubahan;

                HistoriStok::create([
                    'barang_id' => $detail['barang_id'],
                    'batch_id' => $batch->id,
                    'referensi' => 'Pembelian',
                    'id_referensi' => $pembelian->id,
                    'jlh_sebelum' => $jlhSebelum,
                    'jlh_perubahan' => $jlhPerubahan,
                    'jlh_setelah' => $jlhSetelah,
                ]);
            }

            return $pembelian;
        });
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
