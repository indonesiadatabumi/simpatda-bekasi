<?php
ini_set('max_execution_time', 0); // Timeout jadi unlimited detik

function db_log($pesan, $level = 'INFO')
{
    $log_file = 'logs/db.log';

    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] [$level] $pesan\n";

    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

function login_log($pesan, $level = 'INFO')
{
    $log_file = 'logs/login.log';

    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] [$level] $pesan\n";

    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

function inquiry_wp_log($pesan, $level = 'INFO')
{
    $log_file = 'logs/inquiry-wp.log';

    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] [$level] $pesan\n";

    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

function pasar_log($service, $method, $ip_address, $user_agent, $request_body, $response_body, $status_code, $created_at)
{
    global $connect;

    $sql = "INSERT INTO log_pasar (service, method, ip_address, user_agent, request_body, response_body, status_code, created_at)VALUES('$service', '$method', '$ip_address', '$user_agent', '$request_body', '$response_body', '$status_code', '$created_at')";
    $query = pg_query($connect, $sql);

    if (!$query) {
        db_log("Insert log pasar gagal: " . pg_last_error($connect), 'ERROR');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Insert log pasar gagal'
        ]);
        exit;
    }
}

function getQris($data)
{
    $url = 'http://192.168.1.20/simpatda_bekasi/api_qris_pasar/request_qris';
    // $curl = curl_init($url);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

    $headers = array(
        "Content-Type: application/json",
        "Access-Control-Allow-Methods: POST",
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    // var_dump($resp);
    return json_decode($resp);
}

function checkBayar($qris_id, $phone_no)
{
    $username = 'bjbAuthDev';
    $password = 'P@SSW0RD!';
    $url = "http://10.31.224.39/bjb/api/getQRISstatus?qris_id=$qris_id&phone_no=$phone_no";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        'Authorization: Basic ' . base64_encode($username . ':' . $password),
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    // echo($resp);
    return json_decode($resp);
}

function getPhoneNo(&$idUser = 1)
{
    switch ($idUser) {
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
        default:
            $msisdn = '';
            $password = '';
            break;
    }

    $data = array();
    $data['msisdn'] = $msisdn;
    $data['password'] = $password;
    return $data;
}
