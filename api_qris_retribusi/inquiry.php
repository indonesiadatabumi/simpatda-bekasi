<?php
header("Access-Control-Allow-Origin: *");
include_once("/assets/phpqrcode/qrlib.php"); 

require_once "koneksi.php";
require_once "Fungsi.php";
$fungsi = new Fungsi();

$kode_billing = $_POST['kode_billing'];

// cek qris_id
$query_cek_qrisID = "SELECT invoice_id FROM qris_va_spt WHERE kode_billing= '$kode_billing' and barcode IS NOT NULL";
$result_cek_qrisID = pg_query($connect, $query_cek_qrisID);
$row_cek_qrisID = pg_fetch_object($result_cek_qrisID);

if (!$row_cek_qrisID){ //apabila qris_id tidak ditemukan
    $response = [
        'responseCode' => '04',
        'message' => 'Qris Id tidak ditemukan'
    ];
}else {
    $qris_id = $row_cek_qrisID->invoice_id;
    
    $query_tagihan = "SELECT a.*, b.kd_rekening as kd_rekening_bjb FROM v_data_payment_retribusi a 
    LEFT JOIN app_skrd b ON a.spt_kode_billing=b.kd_billing
    WHERE a.spt_kode_billing= '$kode_billing'";
    $result_tagihan = pg_query($connect, $query_tagihan);
    $row_tagihan = pg_fetch_object($result_tagihan);

    switch ($row_tagihan->kd_rekening_bjb) {
        case '4120101':
        case '4120105':
        $phone_no = '081318749377';
        break;
        case '4120214':
        $phone_no = '085695466355';
        break;
        case '41201991':
        $phone_no = '085693442268';
        break;
        case '4120224':
        case '4120310':
        $phone_no = '085693442270';
        break;
        case '4120301':
        $phone_no = '085693442271';
        break;
        case '4120312':
        $phone_no = '085693442272';
        break;
        case '4120107':
        $phone_no = '081318754520';
        break;
        case '4120124':
        $phone_no = '081318754590';
        break;
        case '4120119':
        case '41201191':
        case '41201192':
        case '41201193':
        $phone_no = '085283128339';
        break;
        case '4120120':
        $phone_no = '081318754957';
        break;
        case '4120153':
        $phone_no = '081318754829';
        break;
        case '4120201':
        $phone_no = '081318754827';
        break;
        case '4120202':
        $phone_no = '081318754591';
        break;
        case '4120152':
        $phone_no = '085283061826';
        break;
        case '4120204':
        $phone_no = '085925083944';
        break;
    }

    $check_status_bayar = $fungsi->checkBayar($qris_id, $phone_no);

    $response = [
        'responseCode' => $check_status_bayar->CODE,
        'message' => $check_status_bayar->MSG
    ];
}

echo json_encode($response);
?>