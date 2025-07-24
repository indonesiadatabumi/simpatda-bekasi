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
        $query_tagihan = "SELECT * FROM v_data_payment WHERE spt_kode_billing= '".$kode_billing."'";
        $result_tagihan = pg_query($connect, $query_tagihan);
        $row_tagihan = pg_fetch_object($result_tagihan);

        $masa_pajak1 = date('Y-m-d', strtotime('+1 month', strtotime($row_tagihan->spt_periode_jual1)));
        $spt_idwpwr = $row_tagihan->spt_idwpwr;
        $tagihan = $row_tagihan->spt_pajak;
        $explode = explode('-',$row_tagihan->spt_periode_jual1 );

        if($explode[0] <= '2023' && $explode[1] <= '12'){ // jatuh tempo bayar
            $tgl_jatuh_tempo = date("Y-m-30", strtotime($masa_pajak1));
            $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
            $sanksi_lapor = 0;
        }else {
            $tgl_jatuh_tempo = date("Y-m-10", strtotime($masa_pajak1)); // jatuh tempo bayar

            $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
            
            if(date('d') > '15'){
                $sanksi_lapor = 100000;
            }else {
                $pajak_lalu = date('Y-m-d', strtotime('-1 month', strtotime($row_tagihan->spt_periode_jual1)));
                $explode_pajak_lalu = explode('-',$pajak_lalu);

                if ($explode_pajak_lalu[0] <= '2023' && $explode_pajak_lalu[1] <= '10'){ // jatuh tempo bayar
                    $sanksi_lapor = 0;
                }else {
                    // cek tgl_lapor
                    $query = "SELECT tgl_lapor FROM spt WHERE spt_idwpwr= '$spt_idwpwr' AND spt_periode_jual1 = '$pajak_lalu'";
                    $result = pg_query($connect, $query);
                    $cek_lapor_pajak = pg_fetch_object($result);

                    // $tgl_lapor_lalu = date('d', strtotime($cek_lapor_pajak->tgl_lapor));

                    if ($cek_lapor_pajak == null || date('d', strtotime($cek_lapor_pajak->tgl_lapor)) > '15') {// jatuh tempo lapor
                        $sanksi_lapor = 100000;
                    }else{
                        $sanksi_lapor = 0;
                    }
                }
            }
        }

        if ($row_tagihan->spt_jenis_pajakretribusi == '8' || $row_tagihan->spt_jenis_pajakretribusi == '4'){
            $tgl_jatuh_tempo = $row_tagihan->netapajrek_tgl_jatuh_tempo;;
            $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
            $sanksi_lapor = 0;
        }

        if ($row_tagihan->spt_jenis_pemungutan == '3') {
            $denda = 0;
        }

        // $total_bayar = $tagihan + $denda + $sanksi_lapor;
        $total_bayar = $tagihan + $denda;
        $amount = strval($total_bayar);
        $expired_date = date('Y-m-d', strtotime('+1 days', strtotime($datetime_now)));
        $expInSecond = 86400;
        switch ($row_tagihan->spt_jenis_pajakretribusi) {
            case '1':
                $msisdn = '085813765146';
                $password = '21303b5a38ba944d404c2f92c3509ee95b862e37a2e23b0d185a6933a610b267';
                break;
            
            case '2':
                $msisdn = '085813765147';
                $password = '31dafa3dc4d0136740c85e87f3a1afa78c0b17c0fef41ad5222451f487c574ac';
                break;
            case '3':
                $msisdn = '085813765256';
                $password = 'a421427f0768f3c46eef15154d2e3493f1b75998065109944c5c2f7ac8671205';
                break;
            case '4':
                $msisdn = '085813765239';
                $password = '06de68e3f5d13a64ca6ae1b7833a2d4c26aef19a466aa76144fe6ff65927fe0e';
                break;
            case '6':
                $msisdn = '085813765219';
                $password = 'adf5bbf50b4849c899e14800f097395ac3d9a6a624b6a66a6370275674e535cb';
                break;
            case '7':
                $msisdn = '085813765241';
                $password = 'ec3c4a06f1589e88a46c8537a681a81da2cc0e6ad78dda6a815904239fde1740';
                break;
            case '8':
                $msisdn = '085813765210';
                $password = '5671a62165390dd091d9c85d76787478489d6b653a83fe94827c985e007af9ef';
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
            //insert table qris_va_spt
            $query = "INSERT INTO qris_va_spt (kode_billing, tahun, jns_pajak, jns_billing, amount, create_date, status, barcode, expired_date, invoice_id)
                    VALUES ('$kode_billing', '$tahun', '$row_tagihan->spt_jenis_pajakretribusi', 'QRIS', '$amount', '$date', '0', '$stringQR', '$expired_date', '$invoiceId')";
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
                'status' => 'Create QRIS Gagal',
                'kode_billing' => $kode_billing
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
    }else{
        $response = [
            'status' => 'Create QRIS Sukses',
            'kode_billing' => $kode_billing
        ]; 
    }
} else {
    // cek tagihan
    $query_tagihan = "SELECT * FROM v_data_payment WHERE spt_kode_billing= '".$kode_billing."'";
    $result_tagihan = pg_query($connect, $query_tagihan);
    $row_tagihan = pg_fetch_object($result_tagihan);

    $masa_pajak1 = date('Y-m-d', strtotime('+1 month', strtotime($row_tagihan->spt_periode_jual1)));
    $spt_idwpwr = $row_tagihan->spt_idwpwr;
    $tagihan = $row_tagihan->spt_pajak;
    $explode = explode('-',$row_tagihan->spt_periode_jual1 );
    
    if($explode[0] <= '2023' && $explode[1] <= '12'){// jatuh tempo bayar
        $tgl_jatuh_tempo = date("Y-m-30", strtotime($masa_pajak1));
        $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
        $sanksi_lapor = 0;
    }else {
        $tgl_jatuh_tempo = date("Y-m-10", strtotime($masa_pajak1)); // jatuh tempo bayar
        $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
        
        if(date('d') > '15'){
            $sanksi_lapor = 100000;
        }else {
            $pajak_lalu = date('Y-m-d', strtotime('-1 month', strtotime($row_tagihan->spt_periode_jual1)));
            $explode_pajak_lalu = explode('-',$pajak_lalu);

            if ($explode_pajak_lalu[0] <= '2023' && $explode_pajak_lalu[1] <= '10'){ // jatuh tempo bayar
                $sanksi_lapor = 0;
            }else {
                // cek tgl_lapor
                $query = "SELECT tgl_lapor FROM spt WHERE spt_idwpwr= '$spt_idwpwr' AND spt_periode_jual1 = '$pajak_lalu'";
                $result = pg_query($connect, $query);
                $cek_lapor_pajak = pg_fetch_object($result);

                // $tgl_lapor_lalu = date('d', strtotime($cek_lapor_pajak->tgl_lapor));

                if ($cek_lapor_pajak == null || date('d', strtotime($cek_lapor_pajak->tgl_lapor)) > '15') {// jatuh tempo lapor
                    $sanksi_lapor = 100000;
                }else{
                    $sanksi_lapor = 0;
                }
            }
        }
    }
    
    if ($row_tagihan->spt_jenis_pajakretribusi == '8' || $row_tagihan->spt_jenis_pajakretribusi == '4'){
        $tgl_jatuh_tempo = $row_tagihan->netapajrek_tgl_jatuh_tempo;;
        $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
        $sanksi_lapor = 0;
    }

    if ($row_tagihan->spt_jenis_pemungutan == '3') {
        $denda = 0;
    }

    // $total_bayar = $tagihan + $denda + $sanksi_lapor;
    $total_bayar = $tagihan + $denda;
    $amount = strval($total_bayar);
    $expired_date = date('Y-m-d', strtotime('+1 days', strtotime($datetime_now)));
    $expInSecond = 86400;
    switch ($row_tagihan->spt_jenis_pajakretribusi) {
        case '1':
            $msisdn = '085813765146';
            $password = '21303b5a38ba944d404c2f92c3509ee95b862e37a2e23b0d185a6933a610b267';
            break;
        
        case '2':
            $msisdn = '085813765147';
            $password = '31dafa3dc4d0136740c85e87f3a1afa78c0b17c0fef41ad5222451f487c574ac';
            break;
        case '3':
            $msisdn = '085813765256';
            $password = 'a421427f0768f3c46eef15154d2e3493f1b75998065109944c5c2f7ac8671205';
            break;
        case '4':
            $msisdn = '085813765239';
            $password = '06de68e3f5d13a64ca6ae1b7833a2d4c26aef19a466aa76144fe6ff65927fe0e';
            break;
        case '6':
            $msisdn = '085813765219';
            $password = 'adf5bbf50b4849c899e14800f097395ac3d9a6a624b6a66a6370275674e535cb';
            break;
        case '7':
            $msisdn = '085813765241';
            $password = 'ec3c4a06f1589e88a46c8537a681a81da2cc0e6ad78dda6a815904239fde1740';
            break;
        case '8':
            $msisdn = '085813765210';
            $password = '5671a62165390dd091d9c85d76787478489d6b653a83fe94827c985e007af9ef';
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
        //insert table qris_va_spt
        $query = "INSERT INTO qris_va_spt (kode_billing, tahun, jns_pajak, jns_billing, amount, create_date, status, barcode, expired_date, invoice_id)
        VALUES ('$kode_billing', '$tahun', '$row_tagihan->spt_jenis_pajakretribusi', 'QRIS', '$amount', '$date', '0', '$stringQR', '$expired_date', '$invoiceId')";
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
            'status' => 'Create QRIS Gagal',
            'kode_billing' => $kode_billing
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
}

echo json_encode($response);
?>