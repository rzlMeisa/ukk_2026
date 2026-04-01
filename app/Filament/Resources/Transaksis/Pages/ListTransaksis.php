<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
        Action::make('Keluar')
            ->action(function (Transaksi $record) {
                $waktuKeluar = now();
                $waktuMasuk = \Carbon\Carbon::parse($record->waktu_masuk);
                $durasi = $waktuMasuk->diffInHours($waktuKeluar);
                if ($durasi < 1) $durasi = 1; // Minimal 1 jam [cite: 47]

                $total = $durasi * $record->tarif->tarif_per_jam;

                $record->update([
                    'waktu_keluar' => $waktuKeluar,
                    'durasi_jam' => $durasi,
                    'biaya_total' => $total,
                    'status' => 'keluar',
                ]);
            })
            ->requiresConfirmation()
            ->color('success'),
            
        // Fitur Cetak Struk Sederhana [cite: 71, 96]
        Action::make('CetakStruk')
            ->url(fn (Transaksi $record) => route('cetak.struk', $record))
            ->openUrlInNewTab()
            ->visible(fn (Transaksi $record) => $record->status === 'keluar'),
    ];
    }
}
