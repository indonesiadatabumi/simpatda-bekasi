<?php
header("Access-Control-Allow-Origin: *");
include_once("/assets/phpqrcode/qrlib.php"); 

require_once "koneksi.php";
require_once "Fungsi.php";
$fungsi = new Fungsi();

$kode_billing = $_POST['kode_billing'];

// cek qris_id
$query_cek_qrisID = "SELECT jns_pajak, invoice_id FROM qris_va_spt WHERE kode_billing= '$kode_billing' and barcode IS NOT NULL";
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
    switch ($jns_pajak) {
        case '1':
            $phone_no = '085813765146';
            break;
        
        case '2':
            $phone_no = '085813765147';
            break;
        case '3':
            $phone_no = '085813765256';
            break;
        case '4':
            $phone_no = '085813765239';
            break;
        case '5':
            $phone_no = '085813765219';
            break;
        case '6':
            $phone_no = '085813765219';
            break;
        case '7':
            $phone_no = '085813765241';
            break;
        case '8':
            $phone_no = '085813765210';
            break;
    }

    $check_status_bayar = $fungsi->checkBayar($qris_id, $phone_no);

    // Simpan response dan status
    $target_url = 'http://10.31.224.39/bjb/api/getQRISstatus?qris_id='.$qris_id.'&phone_no='.$phone_no.'';
    $response_body = json_encode($check_status_bayar);
    $status_code =  $check_status_bayar->CODE;
    $error_message =  $check_status_bayar->STATUS;

    $response = [
        'responseCode' => $check_status_bayar->CODE,
        'message' => $check_status_bayar->MSG
    ];
}

echo json_encode($response);
// Simpan data ke api_log_send
try {
    $method = 'POST';
    $query_log = "INSERT INTO api_log_send (target_url, method, response_body, status_code, error_message) VALUES ('$target_url', '$method', '$response_body', '$status_code', '$error_message')";
    $result_log = pg_query($connect, $query_log);

    if (!$result_log) {
        throw new Exception(pg_last_error($connect));
    }
} catch (PDOException $e) {
    echo "Error saat insert log: " . $e->getMessage();
}
?>