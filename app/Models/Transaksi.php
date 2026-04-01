<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'kendaraan_id', 'tarif_id', 'area_id', 'user_id', 
        'waktu_masuk', 'waktu_keluar', 'durasi_jam', 'biaya_total', 'status'
    ];


    public function kendaraan() { return $this->belongsTo(Kendaraan::class); }
    public function tarif() { return $this->belongsTo(Tarif::class); }
    public function area() { return $this->belongsTo(AreaParkir::class); }
    public function user() { return $this->belongsTo(User::class); }

}
