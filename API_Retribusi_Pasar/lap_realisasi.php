<?php
require_once "header.php";
require_once "koneksi.php";
require_once "fungsi.php";

// ambil data realisasi
$query_realisasi = "SELECT EXTRACT(YEAR FROM tgl_pembayaran) AS tahun, EXTRACT(MONTH FROM tgl_pembayaran) as bulan, SUM(total_bayar) AS total_bayar
                    FROM payment_retribusi_pasar
                    WHERE thn_retribusi = '2023'
                    GROUP BY tahun, bulan ORDER BY tahun, bulan";
$result_realisasi = pg_query($connect, $query_realisasi);

if ($result_realisasi == null){ //apabila belum generate qris
    $response = [
        'status' => 'Gagal mendapatkan data'
    ];
}else {
    $myarray = array();
    while ($row_realisasi = pg_fetch_array($result_realisasi)) {
        $myarray[] = [
            'tahun' => $row_realisasi['tahun'],
            'bulan' => $row_realisasi['bulan'],
            'total_bayar' => $row_realisasi['total_bayar'],
        ];
    }
    $response = [
        'status' => 'Sukses',
        'data_realisasi' => $myarray,
    ];
    pg_free_result($result_realisasi);
}

echo json_encode($response);