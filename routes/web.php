<?php


use App\Http\Controllers\ParkirController;
use Illuminate\Support\Facades\Route;
use App\Models\Transaksi;



Route::get('/', function () {
    return redirect('/admin'); 
});


Route::get('/transaksi/cetak/{record}', function (Transaksi $record) {
   
    return view('cetak-struk', ['item' => $record]);
})->name('cetak.struk')->middleware('auth');


Route::get('/laporan/rekap', [ParkirController::class, 'rekap'])
    ->name('laporan.rekap')
    ->middleware(['auth', 'can:access-owner']);
