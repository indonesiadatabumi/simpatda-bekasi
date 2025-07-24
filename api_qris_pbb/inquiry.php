<?php
header("Access-Control-Allow-Origin: *");
include_once("/assets/phpqrcode/qrlib.php"); 

require_once "koneksi.php";
require_once "Fungsi.php";
$fungsi = new Fungsi();

$nop = $_POST['nop'];
$tahun = $_POST['tahun'];

// cek qris_id
$query_cek_qrisID = "SELECT jns_pajak, invoice_id FROM qris_va_pbb WHERE nop= '$nop' and tahun = '$tahun' and barcode IS NOT NULL";
$result_cek_qrisID = pg_query($connect, $query_cek_qrisID);
$row_cek_qrisID = pg_fetch_object($result_cek_qrisID);

if (!$row_cek_qrisID){ //apabila qris_id tidak ditemukan
    $response = [
        'responseCode' => '04',
        'message' => 'Qris Id tidak ditemukan'
    ];
}else {
    $jns_pajak = $row_cek_qrisID->jns_pajak;
    $qris_id = $row_cek_qrisID->invoice_id;
    $phone_no = '08568019682';

    $check_status_bayar = $fungsi->checkBayar($qris_id, $phone_no);

    $response = [
        'responseCode' => $check_status_bayar->CODE,
        'message' => $check_status_bayar->MSG
    ];
}

echo json_encode($response);
?>