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
 
$type = $data['type'];
$merchantName = $data['merchantName'];
$transactionDate = $data['transactionDate'];
$transactionStatus = $data['transactionStatus'];
$transactionAmount = $data['transactionAmount'];
$transactionReference = $data['transactionReference'];
$paymentReference = $data['paymentReference'];
$merchantBalance = $data['merchantBalance'];
$merchantMsisdn = $data['merchantMsisdn'];
$merchantEmail = $data['merchantEmail'];
$merchantMpan = $data['merchantMpan'];
$rrn = $data['rrn'];
$customerName = $data['customerName'];
$invoiceNumber = $data['invoiceNumber'];
$now = date('Y-m-d H:i:s');

//cek data dari tabel qris_va_spt
$query_cek_qris = "SELECT * FROM qris_va_spt WHERE invoice_id= '$invoiceNumber'";
$result_cek_qris = pg_query($connect, $query_cek_qris);
$row_cek_qris = pg_fetch_object($result_cek_qris);
 
if($row_cek_qris == null){
    $response_code	 = "0014";
    $message	     = "Tagihan Tidak Ditemukan";
}else{

    if($row_cek_qris->status =='1'){
        $response_code	 = "0014";
        $message	     = "Pajak sudah terbayar";
    }else{
        
        if ($row_cek_qris->jns_pajak == 'Retribusi Pasar') {
            $data_pasar = json_encode([
                'type' => $type,
                'merchantName' => $merchantName,
                'transactionDate' => $transactionDate,
                'transactionStatus' => $transactionStatus,
                'transactionAmount' => $transactionAmount,
                'transactionReference' => $transactionReference,
                'paymentReference' => $paymentReference,
                'merchantBalance' => $merchantBalance,
                'merchantMsisdn' => $merchantMsisdn,
                'merchantEmail' => $merchantEmail,
                'merchantMpan' => $merchantMpan,
                'rrn' => $rrn,
                'customerName' => $customerName,
                'invoiceNumber' => $invoiceNumber
            ]);
            $send_callback = $fungsi->callbackPasar($data_pasar);
            
            $response_code	 = "0000";
            $message	       = "Success";
        }else if($row_cek_qris->jns_pajak == 'Retribusi Daerah'){
            $data_retribusi = json_encode([
                'type' => $type,
                'merchantName' => $merchantName,
                'transactionDate' => $transactionDate,
                'transactionStatus' => $transactionStatus,
                'transactionAmount' => $transactionAmount,
                'transactionReference' => $transactionReference,
                'paymentReference' => $paymentReference,
                'merchantBalance' => $merchantBalance,
                'merchantMsisdn' => $merchantMsisdn,
                'merchantEmail' => $merchantEmail,
                'merchantMpan' => $merchantMpan,
                'rrn' => $rrn,
                'customerName' => $customerName,
                'invoiceNumber' => $invoiceNumber
            ]);
            $send_callback = $fungsi->callbackRetribusi($data_retribusi);
            
            $response_code	 = "0000";
            $message	       = "Success";
        }else{
            // cek tagihan 
            $query_tagihan = "SELECT * FROM v_data_payment WHERE spt_kode_billing= '$row_cek_qris->kode_billing'";
            $result_tagihan = pg_query($connect, $query_tagihan);
            $row_tagihan = pg_fetch_object($result_tagihan);

            $tgl_bayar = date('Y-m-d');
            $masa_pajak1 = date('Y-m-d', strtotime('+1 month', strtotime($row_tagihan->spt_periode_jual1)));
            $spt_idwpwr = $row_tagihan->spt_idwpwr;
            $tagihan = $row_tagihan->spt_pajak;
            $explode = explode('-',$row_tagihan->spt_periode_jual1 );

            if($explode[0] <= '2023' && $explode[1] <= '10'){// jatuh tempo bayar
                $tgl_jatuh_tempo = date("Y-m-30", strtotime($masa_pajak1));
                $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
                $sanksi_lapor = 0;
            }else {
                $npwprd = $row_tagihan->npwprd;
                $kode_billing = $row_tagihan->spt_kode_billing;
                $tahun_pajak = $row_tagihan->spt_periode;
                $pembayaran_ke = 1;
                $kd_rekening = $row_tagihan->koderek;
                $nm_rekening = $row_tagihan->korek_nama;
                $masa_awal = $row_tagihan->spt_periode_jual1;
                $masa_akhir = $row_tagihan->spt_periode_jual2;
                // $sptpd_yg_dibayar = $tagihan + $denda + $sanksi_lapor;
                
                $tgl_pembayaran = $now;
                $tgl_rekam_bayar = $now;
                $nip_rekam_byr = "40";
                $tgl_ntp = $now;
                $date = date('Y-m-d');
                $tgl_jatuh_tempo = date("Y-m-10", strtotime($masa_pajak1));// jatuh tempo bayar

                if ($row_tagihan->spt_periode_jual1 < '2024-01-01') {
                    $denda = 0;
                    $sanksi_lapor = 0;
                }else {
                    $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
                
                    if (date('d') > '15') {
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
            }

            if ($row_tagihan->spt_jenis_pajakretribusi == '8' || $row_tagihan->spt_jenis_pajakretribusi == '4'){
                $tgl_jatuh_tempo = $row_tagihan->netapajrek_tgl_jatuh_tempo;;
                $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
                $sanksi_lapor = 0;
            }

            if ($row_tagihan->spt_jenis_pemungutan == '3') {
                $denda = 0;
            }
            $sptpd_yg_dibayar = $tagihan + $denda;

            // Mulai transaksi
            pg_query($connect, "BEGIN");

            try {
                // Insert ke payment.pembayaran_sptpd
                $query_payment = "INSERT INTO payment.pembayaran_sptpd (npwprd, kode_billing, tahun_pajak, pembayaran_ke, kd_rekening, nm_rekening, masa_awal, masa_akhir, tagihan, denda, sptpd_yg_dibayar, tgl_pembayaran, tgl_rekam_byr, nip_rekam_byr, ntp, tgl_ntp, status_reversal, tgl_reversal, nip_reversal)VALUES ('$npwprd', '$kode_billing', '$tahun_pajak', $pembayaran_ke, '$kd_rekening', '$nm_rekening', '$masa_awal', '$masa_akhir', $tagihan, $denda, $sptpd_yg_dibayar, '$tgl_pembayaran', '$tgl_rekam_bayar', '$nip_rekam_byr', '$rrn', '$tgl_ntp', null, null, null)";
                $result_payment = pg_query($connect, $query_payment);
                if (!$result_payment) throw new Exception('Gagal insert ke pembayaran_sptpd');

                // Update status tabel qris_va_spt
                $query_update_status_qris = "UPDATE qris_va_spt SET status = '1', transaction_date = '$date' 
                    WHERE invoice_id = '$invoiceNumber'";
                $result_update_status_qris = pg_query($connect, $query_update_status_qris);
                if (!$result_update_status_qris) throw new Exception('Gagal update status qris_va_spt');

                // Update status bayar di tabel spt
                $query_update_status_spt = "UPDATE spt SET status_bayar = '1' 
                    WHERE spt_kode_billing = '$kode_billing'";
                $result_update_status_spt = pg_query($connect, $query_update_status_spt);
                if (!$result_update_status_spt) throw new Exception('Gagal update status spt');

                // Insert ke log_payment_qris
                $query_log = "INSERT INTO log_payment_qris (kode_billing, type, transaction_date, transaction_status, transaction_amount, transaction_reference, payment_reference, merchant_mpan, rrn, invoice_number)VALUES ('$kode_billing', '$type', '$now', '$transactionStatus', '$transactionAmount', '$transactionReference', '$paymentReference', '$merchantMpan', '$rrn', '$invoiceNumber')";
                $result_log = pg_query($connect, $query_log);
                if (!$result_log) throw new Exception('Gagal insert ke log_payment_qris');

                // Semua berhasil, commit
                pg_query($connect, "COMMIT");
                
                $response_code	 = "0000";
                $message	       = "Success";

            } catch (Exception $e) {
                // Rollback jika ada error
                pg_query($connect, "ROLLBACK");
                echo "Transaksi gagal: " . $e->getMessage() . "\n";
            }
        } 
    }
}

 
$arr_stat = array();
$arr_stat['response_code'] = $response_code;
$arr_stat['response_message'] = $message;

 
echo json_encode($arr_stat,JSON_UNESCAPED_SLASHES);

// Simpan log API
try {
    $endpoint    = $_SERVER['REQUEST_URI'];
    $method      = $_SERVER['REQUEST_METHOD'];
    $ip_address  = $_SERVER['REMOTE_ADDR'];
    $user_agent  = $_SERVER['HTTP_USER_AGENT'];
    $response_body = json_encode($arr_stat);
    $status_code = $arr_stat['response_code'];
    $query_log = "INSERT INTO api_log_receive (endpoint, method, ip_address, user_agent, request_body, response_body, status_code, created_at) VALUES ('$endpoint', '$method', '$ip_address', '$user_agent', '$content', '$response_body', '$status_code', '$now')";
    $result_log = pg_query($connect, $query_log);

    if (!$result_log) {
        throw new Exception(pg_last_error($connect));
    }
} catch (PDOException $e) {
    // Catat error log jika perlu
    error_log('Gagal simpan log API: ' . $e->getMessage());
}
