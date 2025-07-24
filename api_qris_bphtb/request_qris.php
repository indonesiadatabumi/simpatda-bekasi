<?php
header("Access-Control-Allow-Origin: *");
include_once("/assets/phpqrcode/qrlib.php"); 

require_once "koneksi.php";
require_once "Fungsi.php";
$fungsi = new Fungsi();

$datetime_now = date('Y-m-d H:i:s');
$kode_billing = $_POST['kode_billing'];
$pokok = $_POST['pokok'];
$denda = $_POST['denda'];
$tahun = $_POST['tahun'];
// cek qris
$query_cek_qris = "SELECT * FROM qris_va_bphtb WHERE kode_billing= '".$kode_billing."' AND barcode IS NOT NULL";
$result_cek_qris = pg_query($connect, $query_cek_qris);
$row_cek_qris = pg_fetch_object($result_cek_qris);

if ($row_cek_qris != null){ // apabila pernah generate qris
    if ($datetime_now > $row_cek_qris->expired_date){ // apabila sudah expired
        // hapus qris lama
        unlink("assets/qris/" . $kode_billing . "png");
        $query_del_qris = "DELETE FROM qris_va_bphtb WHERE kode_billing='$kode_billing' AND barcode IS NOT NULL";
        $result_del_qris = pg_query($connect, $query_del_qris);

        // generate ulang
        $total_bayar = $pokok + $denda;
        $amount = strval($total_bayar);
        $expired_date = date('Y-m-d', strtotime('+1 days', strtotime($datetime_now)));
        $expInSecond = 86400;
        $msisdn = '085813765232';
        $password = 'b9db0f7b00df6013ff3c1ea55134126f70e1f6f18133a5a9a09549f108ae5801';
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
            $query = "INSERT INTO qris_va_bphtb (kode_billing, tahun, jns_pajak, jns_billing, amount, create_date, status, barcode, expired_date, invoice_id)
            VALUES ('$kode_billing', '$tahun', 'BPHTB', 'QRIS', '$amount', '$date', '0', '$stringQR', '$expired_date', '$invoiceId')";
            $result = pg_query($connect, $query);
            //make barcode
            $barcode = $stringQR;
            $codesDir = "assets/qris/";
            $codeFile = $kode_billing . '.png';
            $formData = $barcode;
            QRcode::png($formData, $codesDir . $codeFile);

            $response = [
                'status' => 'Create QRIS Sukses',
                'qris' => $kode_billing
            ]; 
        }else{
            $response = [
                'status' => 'Create QRIS Gagal',
                'qris' => $kode_billing
            ];
        }
    }else{
        $response = [
            'status' => 'Create QRIS Sukses',
            'qris' => $kode_billing
        ]; 
    }
} else {
    $total_bayar = $pokok + $denda;
    $amount = strval($total_bayar);
    $expired_date = date('Y-m-d', strtotime('+1 days', strtotime($datetime_now)));
    $expInSecond = 86400;
    $msisdn = '085813765232';
    $password = 'b9db0f7b00df6013ff3c1ea55134126f70e1f6f18133a5a9a09549f108ae5801';
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
        $query = "INSERT INTO qris_va_bphtb (kode_billing, tahun, jns_pajak, jns_billing, amount, create_date, status, barcode, expired_date, invoice_id)
        VALUES ('$kode_billing', '$tahun', 'BPHTB', 'QRIS', '$amount', '$date', '0', '$stringQR', '$expired_date', '$invoiceId')";
        $result = pg_query($connect, $query);
        //make barcode
        $barcode = $stringQR;
        $codesDir = "assets/qris/";
        $codeFile = $kode_billing . '.png';
        $formData = $barcode;
        QRcode::png($formData, $codesDir . $codeFile);

        $response = [
            'status' => 'Create QRIS Sukses',
            'qris' => $kode_billing
        ]; 
    }else{
        $response = [
            'status' => 'Create QRIS Gagal',
            'qris' => $kode_billing
        ];
    }
}

echo json_encode($response);
?>