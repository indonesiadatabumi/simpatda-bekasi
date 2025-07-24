<?php
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);

$npwrd = $data ['npwrd'];
$amount = $data ['amount'];
$date = date('Y-m-d');
$timestamp = date('Y-m-d H:i:s');
$bln_retribusi = intval(date('m'));
$thn_retribusi = date('Y');

$query = "SELECT a.nm_wp_wr, a.alamat_wp_wr, a.kelurahan, a.kecamatan, a.kota, a.kd_rekening, b.jenis_retribusi, b.dasar_hukum_pengenaan FROM app_reg_wr AS a 
        LEFT JOIN app_ref_jenis_retribusi AS b ON a.kd_rekening=b.kd_rekening 
        WHERE a.npwrd= '$npwrd'";
$result = pg_query($connect, $query);
$row = pg_fetch_object($result);
pg_free_result($result);
if($row == null){
    $response = [
        'status' => 'Gagal',
        'data' => 'Wp Tidak Ditemukan'
    ];
}else{
    $kd_billing = date('Ymd') . rand(0, 999);
    $wp_wr_nama = $row->nm_wp_wr;
    $wp_wr_alamat = $row->alamat_wp_wr;
    $wp_wr_lurah = $row->kelurahan;
    $wp_wr_camat = $row->kecamatan;
    $wp_wr_kabupaten = $row->kota;
    $kd_rekening = $row->kd_rekening;
    $nm_rekening = $row->jenis_retribusi;
    $dasar_pengenaan = $row->dasar_hukum_pengenaan;
    $total_retribusi = intval($amount);

    // get id skrd
    $query_id_skrd = "SELECT MAX(id_skrd)+1 AS id_skrd FROM app_skrd_pasar";
    $result_id_skrd = pg_query($connect, $query_id_skrd);
    $row_id_skrd = pg_fetch_object($result_id_skrd);
    $id_skrd = intval($row_id_skrd->id_skrd);
    pg_free_result($result_id_skrd);
    // get id nota
    $query_id_nota = "SELECT MAX(id_nota)+1 AS id_nota FROM app_nota_perhitungan_pasar";
    $result_id_nota = pg_query($connect, $query_id_nota);
    $row_id_nota = pg_fetch_object($result_id_nota);
    $id_nota = intval($row_id_nota->id_nota);
    pg_free_result($result_id_nota);
    // get nomor skrd & nota perhitungan
    $query_no_skrd = "SELECT MAX(no_skrd)+1 AS no_skrd FROM app_skrd_pasar WHERE thn_retribusi = '$thn_retribusi'";
    $result_no_skrd = pg_query($connect, $query_no_skrd);
    $row_no_skrd = pg_fetch_object($result_no_skrd);
    pg_free_result($result_no_skrd);
    if($row_no_skrd->no_skrd == null) {
        $no_skrd = 1;
    } else {
        $no_skrd = intval($row_no_skrd->no_skrd);
    }

    // insert table app_skrd_pasar
    $query_app_skrd_pasar = "INSERT INTO app_skrd_pasar (no_skrd, bln_retribusi, thn_retribusi, tipe_retribusi, kd_billing, npwrd, wp_wr_nama, wp_wr_alamat, wp_wr_lurah, wp_wr_camat, wp_wr_kabupaten, kd_rekening, nm_rekening, user_input, tgl_input, tgl_skrd, tgl_penetapan, status_ketetapan, status_bayar, status_lunas, id_skrd, no_polisi, no_uji) VALUES ($no_skrd, $bln_retribusi, '$thn_retribusi', '1', '$kd_billing', '$npwrd', '$wp_wr_nama', '$wp_wr_alamat', '$wp_wr_lurah', '$wp_wr_camat', '$wp_wr_kabupaten', '$kd_rekening', '$nm_rekening', 'admin', '$timestamp', '$date', '$date', '0', '0', '0', $id_skrd, null, null)";
    $result_app_skrd_pasar = pg_query($connect, $query_app_skrd_pasar);
    pg_free_result($result_app_skrd_pasar);

    // insert table nota_perhitungan_pasar
    $query_app_nota_perhitungan_pasar = "INSERT INTO app_nota_perhitungan_pasar (npwrd, no_nota_perhitungan, bln_retribusi, thn_retribusi, kd_rekening, nm_rekening, dasar_pengenaan, jenis_ketetapan, keterangan, jenis_bangunan, tipe_bangunan, total_retribusi, imb, fk_skrd, id_nota) VALUES ('$npwrd', $no_skrd, $bln_retribusi, '$thn_retribusi', '$kd_rekening', '$nm_rekening', '$dasar_pengenaan', 'SKRD', '', '', '', $total_retribusi, '', $id_skrd, $id_nota)";
    $result_app_nota_perhitungan_pasar = pg_query($connect, $query_app_nota_perhitungan_pasar);
    pg_free_result($result_app_nota_perhitungan_pasar);

    $response = [
        'status' => 'Sukses',
        'message' => 'Data Tersimpan',
    ];
}
echo json_encode($response);