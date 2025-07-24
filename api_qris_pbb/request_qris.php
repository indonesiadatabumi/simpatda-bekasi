<?php
header("Access-Control-Allow-Origin: *");
include_once("/assets/phpqrcode/qrlib.php"); 

require_once "koneksi.php";
require_once "Fungsi.php";
$fungsi = new Fungsi();

$datetime_now = date('Y-m-d H:i:s');
$nop = $_POST['nop'];
$pokok = $_POST['pokok'];
$diskon = $_POST['diskon'];
$denda = $_POST['denda'];
$tahun = $_POST['tahun'];
$qris_name = $nop.$tahun;

// cek qris
$query_cek_qris = "SELECT * FROM qris_va_pbb WHERE nop= '".$nop."' AND tahun= '$tahun' AND barcode IS NOT NULL";
$result_cek_qris = pg_query($connect, $query_cek_qris);
$row_cek_qris = pg_fetch_object($result_cek_qris);

if ($row_cek_qris != null){ // apabila pernah generate qris
    if ($datetime_now > $row_cek_qris->expired_date){ // apabila sudah expired
        // hapus qris lama
        unlink("assets/qris/" . $qris_name . "png");
        $query_del_qris = "DELETE FROM qris_va_pbb WHERE nop = '$nop' AND tahun = '$tahun'";
        $result_del_qris = pg_query($connect, $query_del_qris);

        // generate ulang
        $total_bayar = $pokok - $diskon + $denda;
        $amount = strval($total_bayar);
        $expired_date = date('Y-m-d', strtotime('+1 days', strtotime($datetime_now)));
        $expInSecond = 86400;
        $msisdn = '08568019682';
        $password = 'f90d7965fe0be6f1ae5f8cdc83c93c7a276aba11afae817a44af04952cf63d0a';
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
        if ($result_qris->responseCode->_text == '1000'){//apabila generate berhasil
            $date = date('Y-m-d');
            $stringQR = $result_qris->stringQR->_text;
            $invoiceId = $result_qris->invoiceId->_text;
            //insert table qris_va_spt
            $query = "INSERT INTO qris_va_pbb (tahun, jns_pajak, jns_billing, amount, create_date, status, barcode, expired_date, invoice_id, nop)
            VALUES ('$tahun', 'PBB', 'QRIS', '$amount', '$date', '0', '$stringQR', '$expired_date', '$invoiceId', '$nop')";
            $result = pg_query($connect, $query);
            //make barcode
            $barcode = $stringQR;
            $codesDir = "assets/qris/";
            $codeFile = $qris_name . '.png';
            $formData = $barcode;
            QRcode::png($formData, $codesDir . $codeFile);

            $response = [
                'status' => 'Create QRIS Sukses',
                'qris_name' => $qris_name
            ]; 
        }else{
            $response = [
                'status' => 'Create QRIS Gagal',
                'qris_name' => $qris_name
            ];
        }
    }else{
        $response = [
            'status' => 'Create QRIS Sukses',
            'qris_name' => $qris_name
        ]; 
    }
} else {
    
    $total_bayar = $pokok - $diskon + $denda;
    $amount = strval($total_bayar);
    $expired_date = date('Y-m-d', strtotime('+1 days', strtotime($datetime_now)));
    $expInSecond = 86400;
    $msisdn = '08568019682';
    $password = 'f90d7965fe0be6f1ae5f8cdc83c93c7a276aba11afae817a44af04952cf63d0a';
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
    if ($result_qris->responseCode->_text == '1000'){//apabila generate berhasil
        $date = date('Y-m-d');
        $stringQR = $result_qris->stringQR->_text;
        $invoiceId = $result_qris->invoiceId->_text;
        //insert table qris_va_spt
        $query = "INSERT INTO qris_va_pbb (tahun, jns_pajak, jns_billing, amount, create_date, status, barcode, expired_date, invoice_id, nop)
        VALUES ('$tahun', 'PBB', 'QRIS', '$amount', '$date', '0', '$stringQR', '$expired_date', '$invoiceId', '$nop')";
        $result = pg_query($connect, $query);
        //make barcode
        $barcode = $stringQR;
        $codesDir = "assets/qris/";
        $codeFile = $qris_name . '.png';
        $formData = $barcode;
        QRcode::png($formData, $codesDir . $codeFile);

        $response = [
            'status' => 'Create QRIS Sukses',
            'qris_name' => $qris_name
        ]; 
    }else{
        $response = [
            'status' => 'Create QRIS Gagal',
            'qris_name' => $qris_name
        ];
    }
}

echo json_encode($response);
?>