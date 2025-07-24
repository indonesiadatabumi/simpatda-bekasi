<?php
header("Access-Control-Allow-Origin: *");
include_once("/assets/phpqrcode/qrlib.php"); 

require_once "koneksi.php";
require_once "Fungsi.php";
$fungsi = new Fungsi();

$datetime_now = date('Y-m-d H:i:s');
$kode_billing = $_POST['idbilling'];
// cek qris
$query_cek_qris = "SELECT * FROM qris_va_spt WHERE kode_billing= '".$kode_billing."' and barcode IS NOT NULL";
$result_cek_qris = pg_query($connect, $query_cek_qris);
$row_cek_qris = pg_fetch_object($result_cek_qris);

if ($row_cek_qris != null){ // apabila pernah generate qris
    if ($datetime_now > $row_cek_qris->expired_date){ // apabila sudah expired
        // hapus qris lama
        unlink("assets/qris/" . $kode_billing . "png");
        $query_del_qris = "DELETE FROM qris_va_spt WHERE kode_billing = '$kode_billing'";
        $result_del_qris = pg_query($connect, $query_del_qris);

        // generate ulang
        $query_tagihan = "SELECT a.*, b.kd_rekening as kd_rekening_bjb FROM v_data_payment_retribusi a 
        LEFT JOIN app_skrd b ON a.spt_kode_billing=b.kd_billing
        WHERE a.spt_kode_billing= '$kode_billing'";
        $result_tagihan = pg_query($connect, $query_tagihan);
        $row_tagihan = pg_fetch_object($result_tagihan);

        $masa_pajak1 = date('Y-m-d', strtotime('+1 month', strtotime($row_tagihan->spt_periode_jual1)));
        $tagihan = $row_tagihan->spt_pajak;
        $tgl_jatuh_tempo = date("Y-m-10", strtotime($masa_pajak1));//jatuh tempo bayar
        // $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
        $denda = 0;

        $total_bayar = $tagihan + $denda;

        $amount = strval($total_bayar);
        $expired_date = date('Y-m-d', strtotime('+1 days', strtotime($datetime_now)));
        $expInSecond = 86400;

        switch ($row_tagihan->kd_rekening_bjb) {
        case '4120101':
        case '4120105':
        $msisdn = '081318749377';
        $password = '2d017d30728e1b8a90b8947d6c56f49bbc024282cb03ed880a1309438cdb943d';
        break;
        case '4120214':
        $msisdn = '085695466355';
        $password = 'ad80d0ace76428b8254b633c90594809d494166a57bc8cd2f258f1757032433b';
        break;
        case '41201991':
        $msisdn = '085693442268';
        $password = 'a52711f348fe75b5dc8172452b076f3e328756782e7fa8522b8b89da9b6f5cee';
        break;
        case '4120224':
        case '4120310':
        $msisdn = '085693442270';
        $password = 'c7527a117000cebd6ebbc74c9a2d90f758f5e8cdbadb94e37bf2471956e11916';
        break;
        case '4120301':
        $msisdn = '085693442271';
        $password = 'af10c0c7dc2f6d2934bb8c89b5c72b175ec9133db61c275e2aa2a7a011adc77f';
        break;
        case '4120312':
        $msisdn = '085693442272';
        $password = '48042705efea2870f5fd7e5d3e67562a1e236b4a4839af8c81ba5621a2496b66';
        break;
        case '4120107':
        $msisdn = '081318754520';
        $password = 'cea46a3e22f6180c33e4389413f4653ef9e4d52486b61ccaa2c043d23ffef771';
        break;
        case '4120124':
        $msisdn = '081318754590';
        $password = 'dbbebfbdc50f0f1d4327b6da1bf17985dde0fa7473f2598292b49e933eed8cf5';
        break;
        case '4120119':
        case '41201191':
        case '41201192':
        case '41201193':
        $msisdn = '085283128339';
        $password = '8d8f56b7a75a7b9c3204e326a4af384ee7e312fb815d4752934bcdbc0f17a6c1';
        break;
        case '4120120':
        $msisdn = '081318754957';
        $password = '401b282e8bb6ae5e20cbc80c8f207fa4a90d039bd94296320af80df9ce713a0c';
        break;
        case '4120153':
        $msisdn = '081318754829';
        $password = 'e4f2c52970c61c716e0e602c1a35a15373d120629d0efa8f63b95af0f39e056f';
        break;
        case '4120201':
        $msisdn = '081318754827';
        $password = '5af02825b9f12e7bbf4b34f540fe2d10f36c63e12fe97fc89db0fa443ba3a16d';
        break;
        case '4120202':
        $msisdn = '081318754591';
        $password = '4ae2b042dddc11700b5c2fbbde3c219a47d3a0461878928f892e17c267cff82e';
        break;
        case '4120152':
        $msisdn = '085283061826';
        $password = 'c128f931a2d515f910e19637c5693297bf0eccc77451af44401a5b84052f5a5c';
        break;
        case '4120204':
        $msisdn = '085925083944';
        $password = '06a1c4c2632242abc108a2476b36982ba3399625d1502ba3004b9f8e8b66d364';
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
        
        if ($result_qris->responseCode->_text == '1000'){//apabila generate berhasil
        $date = date('Y-m-d');
        $tahun = date('Y');
        $stringQR = $result_qris->stringQR->_text;
        $invoiceId = $result_qris->invoiceId->_text;
        //insert table qris_va_spt
        $query = "INSERT INTO qris_va_spt (kode_billing, tahun, jns_pajak, jns_billing, amount, create_date, status, barcode, expired_date, invoice_id)
        VALUES ('$kode_billing', '$tahun', 'Retribusi Daerah', 'QRIS', '$amount', '$date', '0', '$stringQR', '$expired_date', '$invoiceId')";
        $result = pg_query($connect, $query);
        //make barcode
        $barcode = $stringQR;
        $codesDir = "assets/qris/";
        $codeFile = $kode_billing . '.png';
        $formData = $barcode;
        QRcode::png($formData, $codesDir . $codeFile);

        $response = [
        'status' => 'Create QRIS Sukses',
        'kode_billing' => $kode_billing
        ]; 
        }else{
        $response = [
        'status' => 'Create QRIS Gagal',
        'kode_billing' => $kode_billing
        ];
        }
    }else{
        $response = [
            'status' => 'Create QRIS Sukses',
            'kode_billing' => $kode_billing
        ]; 
    }
} else {
    // cek tagihan
    $query_tagihan = "SELECT a.*, b.kd_rekening as kd_rekening_bjb FROM v_data_payment_retribusi a 
                    LEFT JOIN app_skrd b ON a.spt_kode_billing=b.kd_billing
                    WHERE a.spt_kode_billing= '$kode_billing'";
    $result_tagihan = pg_query($connect, $query_tagihan);
    $row_tagihan = pg_fetch_object($result_tagihan);
    
    $masa_pajak1 = date('Y-m-d', strtotime('+1 month', strtotime($row_tagihan->spt_periode_jual1)));
    $tagihan = $row_tagihan->spt_pajak;
    $tgl_jatuh_tempo = date("Y-m-10", strtotime($masa_pajak1));//jatuh tempo bayar
    // $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
    $denda= 0;
    
    $total_bayar = $tagihan + $denda;

    $amount = strval($total_bayar);
    $expired_date = date('Y-m-d', strtotime('+1 days', strtotime($datetime_now)));
    $expInSecond = 86400;
    
    switch ($row_tagihan->kd_rekening_bjb) {
        case '4120101':
        case '4120105':
            $msisdn = '081318749377';
            $password = '2d017d30728e1b8a90b8947d6c56f49bbc024282cb03ed880a1309438cdb943d';
            break;
        case '4120214':
            $msisdn = '085695466355';
            $password = 'ad80d0ace76428b8254b633c90594809d494166a57bc8cd2f258f1757032433b';
            break;
        case '41201991':
            $msisdn = '085693442268';
            $password = 'a52711f348fe75b5dc8172452b076f3e328756782e7fa8522b8b89da9b6f5cee';
            break;
        case '4120224':
        case '4120310':
            $msisdn = '085693442270';
            $password = 'c7527a117000cebd6ebbc74c9a2d90f758f5e8cdbadb94e37bf2471956e11916';
            break;
        case '4120301':
            $msisdn = '085693442271';
            $password = 'af10c0c7dc2f6d2934bb8c89b5c72b175ec9133db61c275e2aa2a7a011adc77f';
            break;
        case '4120312':
            $msisdn = '085693442272';
            $password = '48042705efea2870f5fd7e5d3e67562a1e236b4a4839af8c81ba5621a2496b66';
            break;
        case '4120107':
            $msisdn = '081318754520';
            $password = 'cea46a3e22f6180c33e4389413f4653ef9e4d52486b61ccaa2c043d23ffef771';
            break;
        case '4120124':
            $msisdn = '081318754590';
            $password = 'dbbebfbdc50f0f1d4327b6da1bf17985dde0fa7473f2598292b49e933eed8cf5';
            break;
        case '4120119':
        case '41201191':
        case '41201192':
        case '41201193':
            $msisdn = '085283128339';
            $password = '8d8f56b7a75a7b9c3204e326a4af384ee7e312fb815d4752934bcdbc0f17a6c1';
            break;
        case '4120120':
            $msisdn = '081318754957';
            $password = '401b282e8bb6ae5e20cbc80c8f207fa4a90d039bd94296320af80df9ce713a0c';
            break;
        case '4120153':
            $msisdn = '081318754829';
            $password = 'e4f2c52970c61c716e0e602c1a35a15373d120629d0efa8f63b95af0f39e056f';
            break;
        case '4120201':
            $msisdn = '081318754827';
            $password = '5af02825b9f12e7bbf4b34f540fe2d10f36c63e12fe97fc89db0fa443ba3a16d';
            break;
        case '4120202':
            $msisdn = '081318754591';
            $password = '4ae2b042dddc11700b5c2fbbde3c219a47d3a0461878928f892e17c267cff82e';
            break;
        case '4120152':
            $msisdn = '085283061826';
            $password = 'c128f931a2d515f910e19637c5693297bf0eccc77451af44401a5b84052f5a5c';
            break;
        case '4120204':
            $msisdn = '085925083944';
            $password = '06a1c4c2632242abc108a2476b36982ba3399625d1502ba3004b9f8e8b66d364';
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
    
    if ($result_qris->responseCode->_text == '1000'){//apabila generate berhasil
        $date = date('Y-m-d');
        $tahun = date('Y');
        $stringQR = $result_qris->stringQR->_text;
        $invoiceId = $result_qris->invoiceId->_text;
        //insert table qris_va_spt
        $query = "INSERT INTO qris_va_spt (kode_billing, tahun, jns_pajak, jns_billing, amount, create_date, status, barcode, expired_date, invoice_id)
        VALUES ('$kode_billing', '$tahun', 'Retribusi Daerah', 'QRIS', '$amount', '$date', '0', '$stringQR', '$expired_date', '$invoiceId')";
        $result = pg_query($connect, $query);
        //make barcode
        $barcode = $stringQR;
        $codesDir = "assets/qris/";
        $codeFile = $kode_billing . '.png';
        $formData = $barcode;
        QRcode::png($formData, $codesDir . $codeFile);

        $response = [
            'status' => 'Create QRIS Sukses',
            'kode_billing' => $kode_billing
        ]; 
    }else{
        $response = [
            'status' => 'Create QRIS Gagal',
            'kode_billing' => $kode_billing
        ];
    }
}

echo json_encode($response);
?>