<?php
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);

$npwrd = $data['npwrd'];
$now = date('Y-m-d H:i:s');

$query = "SELECT reg.npwrd, reg.nm_wp_wr, reg.alamat_wp_wr, reg.kelurahan, reg.kecamatan, reg.kota FROM app_reg_wr as reg WHERE npwrd= '$npwrd'";
$result = pg_query($connect, $query);
$row = pg_fetch_object($result);
pg_free_result($result);
if($row == null){
    $response = [
        'status' => 'Gagal',
        'data' => 'Wp Tidak Ditemukan'
    ];
}else{
    $query2 = "SELECT total_retribusi FROM app_nota_perhitungan_pasar WHERE npwrd= '$npwrd' ORDER BY fk_skrd DESC";
    $result2 = pg_query($connect, $query2);
    $row2 = pg_fetch_object($result2);
    pg_free_result($result2);

    //insert table app_log_retribusi_pasar
    $query_log = "INSERT INTO app_log_retribusi_pasar (npwrd, nama_wp, alamat_wp, amount, created_time) VALUES ('$npwrd', '$row->nm_wp_wr', '$row->alamat_wp_wr', $row2->total_retribusi, '$now')";
    $result_log = pg_query($connect, $query_log);
    pg_free_result($result_log);

    $data = [
        'npwrd' => $row->npwrd,
        'nm_wp_wr' => $row->nm_wp_wr,
        'alamat_wp_wr' => $row->alamat_wp_wr,
        'kelurahan' => $row->kelurahan,
        'kecamatan' => $row->kecamatan,
        'kota' => $row->kota,
        'nominal_pengenaan' => $row2->total_retribusi
    ];
    $response = [
        'status' => 'Sukses',
        'data_wp' => $data,
    ];
}

echo json_encode($response);