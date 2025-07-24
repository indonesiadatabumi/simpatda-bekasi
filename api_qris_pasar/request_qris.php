<?php
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once "koneksi.php";
require_once "Fungsi.php";
$fungsi = new Fungsi();

//mengubah standar encoding
$content    = file_get_contents("php://input");
$content    = utf8_encode($content);
$data       = json_decode($content,TRUE);

$datetime_now = date('Y-m-d H:i:s');
$id_user = $data['id_user'];
$total_bayar = $data['amount'];

$amount = $total_bayar;
$expInSecond = 7200;
switch ($id_user) {
    case '1':
        $msisdn = '085880701507';
        $password = 'f374677bce99fb84bd51b5b4037bfd3675052c5e423f0d92b401a2c22b652aea';
        break;
    case '2':
        $msisdn = '085880701495';
        $password = 'f2980419de8645e72d45f1aaab8d9d9a8c893700c0e6c21fba2fb2bd8a572e87';
        break;
    case '3':
        $msisdn = '08568240622';
        $password = '93db4693af478c99d4f70d9cf4fb02fa4957ce0a896eb8ff12d255d213979226';
        break;
    case '4':
        $msisdn = '08568240623';
        $password = '8c679de5e4d09215318e6ab162b7dae16145ce9bfb2b81c2dad84d29b991ad7e';
        break;
    case '5':
        $msisdn = '085880701527';
        $password = '037af78ed4e4860c7f77cfb8c0041c7c5e8c37b337b791284c5e7752e4a7bdb8';
        break;
}
// metadata untuk token fintech
$metadata_token = [
    'datetime' => $datetime_now,
    'deviceId' => 'bjbdigi',
    'devicePlatform' => 'Linux',
    'deviceOSVersion' => 'bjbdigi-version',
    'deviceType' => '',
    'latitude' => '',
    'longitude' => '',
    'appId' => '4',
    'appVersion' => '1.0'
];
// body untuk token fintech
$body_token = [
    'msisdn' => $msisdn,
    'password' => $password
];
$data_token = json_encode([
    'metadata' => $metadata_token,
    'body' => $body_token
]);
//api untuk token fintech
$get_token_fintech = $fungsi->token_fintech($data_token);

//convert to array from response
$array_token_fintech = $fungsi->get_headers_from_curl_response($get_token_fintech);
$token_fintech = $array_token_fintech[0]['X-AUTH-TOKEN'];

//metadata untuk get qris
$metadata_qris = [
    'datetime' => $datetime_now,
    'deviceId' => 'bjbdigi',
    'deviceType' => '',
    'devicePlatform' => 'Linux',
    'deviceOSVersion' => 'bjbdigi-version',
    'appId' => '4',
    'appVersion' => '1.0',
    'latitude' => '',
    'longitude' => ''
];
//body untuk get qris
$body_qris = [
    'merchantAccountNumber' => $msisdn,
    'amount' => $amount,
    'expInSecond' => $expInSecond
];
$data_qris = json_encode([
    'metadata' => $metadata_qris,
    'body' => $body_qris
]);
//api untuk get qris
$get_qris = $fungsi->getQris($token_fintech, $data_qris);
$result_qris = $get_qris->body->CreateInvoiceQRISDinamisExtResponse;
$responseCode = $result_qris->responseCode->_text;
$responseMessage = $result_qris->responseMessage->_text;

// Simpan response dan status
$target_url = 'http://10.31.224.39:8080/mobile-webconsole/apps/4/pbTransactionAdapter/createInvoiceQRISDinamisExt';
$response_body = json_encode($get_qris);
$status_code = property_exists($result_qris, 'responseCode') ? $responseCode : null;
$error_message = property_exists($result_qris, 'responseMessage') ? $responseMessage : null;

if ($result_qris->responseCode->_text == '1000'){//apabila generate berhasil
    $date = date('Y-m-d');
    $tahun = date('Y');
    $stringQR = $result_qris->stringQR->_text;
    $invoiceId = $result_qris->invoiceId->_text;
    
    $response = [
        'status' => 'Create QRIS Sukses',
        'qris' => $stringQR,
        'invoice_id' => $invoiceId
    ]; 

    // Simpan data ke api_log_send
    try {
        $method = 'POST';
        $query_log = "INSERT INTO api_log_send (target_url, method, request_body, response_body, status_code, error_message, created_at) VALUES ('$target_url', '$method', '$data_qris', '$response_body', '$status_code', '$error_message', '$datetime_now')";
        $result_log = pg_query($connect, $query_log);

        if (!$result_log) {
            throw new Exception(pg_last_error($connect));
        }
    } catch (PDOException $e) {
        echo "Error saat insert log: " . $e->getMessage();
    }
}else{
    $response = [
        'status' => 'Create QRIS Gagal'    
    ];

    // Simpan data ke api_log_send
    try {
        $method = 'POST';
        $query_log = "INSERT INTO api_log_send (target_url, method, request_body, response_body, status_code, error_message, created_at) VALUES ('$target_url', '$method', '$data_qris', '$response_body', '$status_code', '$error_message', '$datetime_now')";
        $result_log = pg_query($connect, $query_log);

        if (!$result_log) {
            throw new Exception(pg_last_error($connect));
        }
    } catch (PDOException $e) {
        echo "Error saat insert log: " . $e->getMessage();
    }
}

echo json_encode($response);
?>