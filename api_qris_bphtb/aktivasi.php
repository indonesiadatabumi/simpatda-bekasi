<?php
header("Access-Control-Allow-Origin: *"); 

require_once "koneksi.php";
require_once "Fungsi.php";
$fungsi = new Fungsi();

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
    'appId' => '4',
    'appVersion' => '1.0'
];
// body untuk token fintech
$body_token = [
    'msisdn' => '080000000002',
    'password' => 'c3e4bbf32a586b2011e0eaf11d841c3dccd07665ff7d7e0be7e0af981527994b'
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

// //metadata untuk otp
// $metadata_otp = [
//     'datetime' => $datetime_now,
//     'deviceId' => 'bjbdigi',
//     'devicePlatform' => 'Linux',
//     'deviceOSVersion' => 'bjbdigi-version',
//     'deviceType' => '',
//     'latitude' => '',
//     'longitude' => '',
//     'appId' => '4',
//     'appVersion' => '1.0'
// ];
// //body untuk otp
// $body_otp = [
//     'phoneNo' => '082234827253',
// ];
// $data_otp = json_encode([
//     'metadata' => $metadata_otp,
//     'body' => $body_otp
// ]);
// //api untuk token fintech
// $get_otp = $fungsi->otp($token_fintech, $data_otp);
// die;

//metadata untuk aktivasi
$metadata_aktivasi = [
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
//body untuk aktivasi
$body_aktivasi = [
    'msisdn' => '082234827253',
    'pin' => '111111',
    'reference' => '20f3c824-a9d5-416c-9ef9-7c992561f182',
    'product' => 'MERCHANT'
];
$data_aktivasi = json_encode([
    'metadata' => $metadata_aktivasi,
    'body' => $body_aktivasi
]);
//api untuk get qris
$get_aktivasi = $fungsi->getAktivasi($token_fintech, $data_aktivasi);

die;
?>