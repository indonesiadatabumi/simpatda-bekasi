<?php
header("Access-Control-Allow-Origin: *"); 

require_once "koneksi.php";
require_once "Fungsi.php";
$fungsi = new Fungsi();

$msisdn = $_POST['msisdn'];
$pin = $_POST['pin'];
$reference = $_POST['reference'];
$datetime_now = date('Y-m-d H:i:s');
// metadata untuk token fintech
$metadata_token = [
    'datetime' => $datetime_now,
    'deviceId' => 'bjbdigi',
    'devicePlatform' => 'Linux',
    'deviceOSVersion' => 'bjbdigi-version',
    'deviceType' => '',
    'latitude' => '',
    'longitude' => '',
    'appId' => '63',
    'appVersion' => '1.0'
];
// body untuk token fintech
$body_token = [
    'msisdn' => '980000000063',
    'password' => 'a6bc5641c70f7d5a4a3bab14105282c49b653b05489616850b4c990a3a64a505'
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

//metadata untuk aktivasi
$metadata_aktivasi = [
    'datetime' => $datetime_now,
    'deviceId' => 'bjbdigi',
    'devicePlatform' => 'Linux',
    'deviceOSVersion' => 'bjbdigi-version',
    'deviceType' => '',
    'latitude' => '',
    'longitude' => '',
    'appId' => '63',
    'appVersion' => '1.0'
];
//body untuk aktivasi
$body_aktivasi = [
    'msisdn' => $msisdn,
    'pin' => $pin,
    'reference' => $reference,
    'product' => 'MERCHANT'
];
$data_aktivasi = json_encode([
    'metadata' => $metadata_aktivasi,
    'body' => $body_aktivasi
]);
$token_fintech = "";
//api untuk get aktivasi
$get_aktivasi = $fungsi->getAktivasi($token_fintech, $data_aktivasi);

// Simpan response dan status
$target_url = 'http://10.31.224.39:8080/mobile-webconsole/apps/4/pbNonFinancialAdapter//authorizationRegistration';
$response_body = json_encode($get_aktivasi);
$status_code = '200';
$error_message = 'OK';

echo json_encode($get_aktivasi);
// Simpan data ke api_log_send
try {
    $method = 'POST';
    $query_log = "INSERT INTO api_log_send (target_url, method, request_body, response_body, status_code, error_message) VALUES ('$target_url', '$method', '$data_aktivasi', '$response_body', '$status_code', '$error_message')";
    $result_log = pg_query($connect, $query_log);

    if (!$result_log) {
        throw new Exception(pg_last_error($connect));
    }
} catch (PDOException $e) {
    echo "Error saat insert log: " . $e->getMessage();
}
?>