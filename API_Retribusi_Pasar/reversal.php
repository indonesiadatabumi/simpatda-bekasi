<?php
// $time_start = microtime(true);
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);

$npwrd = $data['npwrd'];
$tgl_skrd = $data['tgl_skrd'];

// cek ketetapan
$query_cek_ketetapan = "SELECT kd_billing, id_skrd FROM app_skrd_pasar WHERE npwrd= '$npwrd' AND tgl_skrd = '$tgl_skrd'";
$result_cek_ketetapan = pg_query($connect, $query_cek_ketetapan);
$row_cek_ketetapan = pg_fetch_object($result_cek_ketetapan);
pg_free_result($result_cek_ketetapan);

if ($row_cek_ketetapan == null){ //apabila belum pernah daftar
    $response = [
        'status' => 'gagal',
        'message' => 'Data Tidak Ditemukan'
    ];
}else {
    $kd_billing = $row_cek_ketetapan->kd_billing;
    $id_skrd = $row_cek_ketetapan->id_skrd;

    //delete app_skrd_pasar
    $query_del_skrd = "DELETE FROM app_skrd_pasar WHERE kd_billing = '$kd_billing' AND id_skrd = '$id_skrd'";
    $result_del_skrd = pg_query($connect, $query_del_skrd);

    //delete app_nota_perhitungan_pasar
    $query_del_nota = "DELETE FROM app_nota_perhitungan_pasar WHERE fk_skrd = '$id_skrd'";
    $result_del_nota = pg_query($connect, $query_del_nota);

    //delete app_qris_retribusi
    $query_del_qris = "DELETE FROM app_qris_retribusi WHERE kode_billing = '$kd_billing' AND status_bayar = '0'";
    $result_del_qris = pg_query($connect, $query_del_qris);

    //delete qris_va_spt
    $query_del_qris2 = "DELETE FROM qris_va_spt WHERE kode_billing = '$kd_billing' AND status = '0'";
    $result_del_qris2 = pg_query($connect, $query_del_qris2);

    $response = [
        'status' => 'sukses',
        'message' => 'Data Berhasil Dihapus'
    ];
}
echo json_encode($response);
// $time_end = microtime(true);
// $time = $time_end - $time_start;
// echo "Login success in $time seconds\n";