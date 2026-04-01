
<!DOCTYPE html>
<html>
<head>
    <title>Struk Parkir - {{ $item->kendaraan->plat_nomor }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 300px; }
        .text-center { text-align: center; }
        hr { border-top: 1px dashed black; }
    </style>
</head>
<body onload="window.print()"> <div class="text-center">
        <h3>STRUK PARKIR UKK</h3>
        <p>Jl. Raya Software Developer No. 2</p>
    </div>
    <hr>
    <pre>
ID Transaksi : {{ $item->id }}
Petugas      : {{ $item->user->nama_lengkap }}
Area         : {{ $item->area->nama_area }}
------------------------------
Plat Nomor   : {{ $item->kendaraan->plat_nomor }}
Jenis        : {{ $item->tarif->jenis_kendaraan }}
Masuk        : {{ $item->waktu_masuk }}
Keluar       : {{ $item->waktu_keluar }}
Durasi       : {{ $item->durasi_jam }} Jam
------------------------------
TOTAL BAYAR  : Rp {{ number_cast($item->biaya_total) }}
    </pre>
    <hr>
    <div class="text-center">
        <p>Terima Kasih Atas Kunjungan Anda</p>
        <p>Simpan Struk Ini Baik-baik</p>
    </div>
</body>
</html>




