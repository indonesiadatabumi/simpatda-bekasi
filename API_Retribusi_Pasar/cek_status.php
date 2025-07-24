<?php
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";
require_once "fungsi.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);

$npwrd = $data ['npwrd'];
$amount = $data ['amount'];
$date = date('Y-m-d');

// cek generate qris
$query_cek_qris = "SELECT a.npwrd, a.kode_billing, a.amount, a.status_bayar, a.create_date, a.expired_date, a.transaction_date, a.barcode, a.invoice_id FROM app_qris_retribusi as a WHERE npwrd= '$npwrd' AND create_date = '$date' AND amount = $amount";
$result_cek_qris = pg_query($connect, $query_cek_qris);
$row_cek_qris = pg_fetch_object($result_cek_qris);
pg_free_result($result_cek_qris);
if ($row_cek_qris == null){ //apabila belum generate qris
    $response = [
        'status' => 'Belum generate qris'
    ];
}else {
    $npwrd = $row_cek_qris->npwrd;
    $kode_billing = $row_cek_qris->kode_billing;
    $amount = $row_cek_qris->amount;
    $status_bayar = $row_cek_qris->status_bayar;
    $create_date = $row_cek_qris->create_date;
    $expired_date = $row_cek_qris->expired_date;
    $transaction_date = $row_cek_qris->transaction_date;
    $barcode = $row_cek_qris->barcode;
    $invoice_id = $row_cek_qris->invoice_id;
    $response = [
        'status' => 'Sukses',
        'npwrd' => $npwrd,
        'kode_billing' => $kode_billing,
        'amount' => $amount,
        'status_bayar' => $status_bayar,
        'create_date' => $create_date,
        'expired_date' => $expired_date,
        'transaction_date' => $transaction_date,
        'barcode' => $barcode,
        'invoice_id' => $invoice_id,
    ];
}

echo json_encode($response);