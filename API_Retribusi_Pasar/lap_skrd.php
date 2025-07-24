<?php
require "header.php";
require_once "koneksi.php";
require_once "input.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);

$id_user = $data['id_user'];
$date = date('Y-m-d');

$query = "SELECT a.id_skrd, a.thn_retribusi, a.bln_retribusi, a.npwrd, a.wp_wr_nama, a.wp_wr_alamat, a.wp_wr_lurah, a.wp_wr_camat, a.wp_wr_kabupaten, a.tgl_skrd, a.kd_billing, a.status_ketetapan, a.status_bayar, a.status_lunas, b.kd_rekening, b.nm_rekening, b.total_retribusi, c.id_user 
FROM app_skrd_pasar AS a  
LEFT JOIN app_nota_perhitungan_pasar AS b ON a.id_skrd=b.fk_skrd AND a.npwrd=b.npwrd
LEFT JOIN app_qris_retribusi AS c ON a.kd_billing=c.kode_billing 
WHERE a.tgl_penetapan = '$date' AND c.id_user = '$id_user' ORDER BY a.id_skrd DESC";
$result = pg_query($connect, $query);

// a.id_skrd
// a.thn_retribusi
// a.bln_retribusi
// a.npwrd
// a.wp_wr_nama
// a.wp_wr_alamat
// a.wp_wr_lurah
// a.wp_wr_camat
// a.wp_wr_kabupaten
// a.tgl_skrd
// a.kd_billing
// a.status_ketetapan
// a.status_bayar
// a.status_lunas

if($result == null){
    $response = [
        'status' => 'Gagal',
        'data' => 'Data Tidak Ditemukan'
    ];
}else{
    $myarray = array();
    while ($row = pg_fetch_array($result)) {
        $myarray[] = [
            'id_skrd' => $row['id_skrd'],
            'thn_retribusi' => $row['thn_retribusi'],
            'bln_retribusi' => $row['bln_retribusi'],
            'npwrd' => $row['npwrd'],
            'wp_wr_nama' => $row['wp_wr_nama'],
            'wp_wr_alamat' => $row['wp_wr_alamat'],
            'wp_wr_lurah' => $row['wp_wr_lurah'],
            'wp_wr_camat' => $row['wp_wr_camat'],
            'wp_wr_kabupaten' => $row['wp_wr_kabupaten'],
            'kd_rekening' => $row['kd_rekening'],
            'nm_rekening' => $row['nm_rekening'],
            'tgl_skrd' => $row['tgl_skrd'],
            'kode_billing' => $row['kd_billing'],
            'total_retribusi' => $row['total_retribusi'],
            'status_ketetapan' => $row['status_ketetapan'],
            'status_bayar' => $row['status_bayar'],
            'status_lunas' => $row['status_lunas'],
        ];
    }
    $response = [
        'status' => 'Sukses',
        'data_skrd' => $myarray,
    ];
    pg_free_result($result);
}

echo json_encode($response);