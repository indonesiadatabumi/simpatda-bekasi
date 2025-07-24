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
        // cek tagihan 
        $query_tagihan = "SELECT a.*, b.kd_rekening as kd_rekening_detil FROM v_data_payment_retribusi a 
        LEFT JOIN app_ref_jenis_retribusi b ON a.korek_nama=b.jenis_retribusi 
        WHERE a.spt_kode_billing= '".$row_cek_qris->kode_billing."'";
        $result_tagihan = pg_query($connect, $query_tagihan);
        $row_tagihan = pg_fetch_object($result_tagihan);

        $query_max_id_pembayaran = "SELECT MAX(id_pembayaran)+1 as id_pembayaran FROM app_pembayaran_retribusi";
        $result_id_pembayaran = pg_query($connect, $query_max_id_pembayaran);
        $row_id_pembayaran = pg_fetch_object($result_id_pembayaran);

        $tgl_bayar = date('Y-m-d');
        $masa_pajak1 = date('Y-m-d', strtotime('+1 month', strtotime($row_tagihan->spt_periode_jual1)));
        $tgl_jatuh_tempo = date("Y-m-10", strtotime($masa_pajak1));//jatuh tempo bayar

        $id_pembayaran = $row_id_pembayaran->id_pembayaran;
        $npwprd = $row_tagihan->npwprd;
        $bln_retribusi = $row_tagihan->bln_retribusi;
        $kode_billing = $row_tagihan->spt_kode_billing;
        $tahun_pajak = $row_tagihan->spt_periode;
        $pembayaran_ke = 1;
        $kd_rekening = $row_tagihan->kd_rekening_detil;
        $nm_rekening = $row_tagihan->korek_nama;
        $masa_awal = $row_tagihan->spt_periode_jual1;
        $masa_akhir = $row_tagihan->spt_periode_jual2;
        $tagihan = $row_tagihan->spt_pajak;
        // $denda= $fungsi->denda($tgl_jatuh_tempo, date('Y-m-d'), $tagihan);
        $denda = 0;
        $sptpd_yg_dibayar = $tagihan + $denda;
        $transaction_time = DateTime::createFromFormat('d/m/Y H:i:s', $transactionDate);
        $tgl_pembayaran = $transaction_time->format('Y-m-d H:i:s');
        $tgl_rekam_bayar = $transaction_time->format('Y-m-d H:i:s');
        $nip_rekam_byr = "40";
        $ntp = date('YmdHis');
        $tgl_ntp = $transaction_time->format('Y-m-d H:i:s');
        $date = date('Y-m-d');

        // Mulai transaksi
        pg_query($connect, "BEGIN");

        try {
            // insert table pembayaran_sptpd
            $query_payment = "INSERT INTO payment.pembayaran_sptpd (npwprd, kode_billing, tahun_pajak, pembayaran_ke, kd_rekening, nm_rekening, masa_awal, masa_akhir, tagihan, denda, sptpd_yg_dibayar, tgl_pembayaran, tgl_rekam_byr, nip_rekam_byr, ntp, tgl_ntp, status_reversal, tgl_reversal, nip_reversal)VALUES ('$npwprd', '$kode_billing', '$tahun_pajak', $pembayaran_ke, '$kd_rekening', '$nm_rekening', '$masa_awal', '$masa_akhir', $tagihan, $denda, $sptpd_yg_dibayar, '$tgl_pembayaran', '$tgl_rekam_bayar', '$nip_rekam_byr', '$rrn', '$tgl_ntp', null, null, null)";
               
            $result_payment = pg_query($connect, $query_payment);
            if (!$result_payment) throw new Exception('Gagal insert pembayaran_sptpd');

            // insert table app_pembayaran_retribusi
            $query3 = "INSERT INTO app_pembayaran_retribusi (id_pembayaran, npwrd, bln_retribusi, thn_retribusi, kd_billing, kd_rekening, nm_rekening, ntpd, pembayaran_ke, total_retribusi, denda, total_bayar, tgl_pembayaran, nip_rekam_bayar, status_reversal)VALUES ($id_pembayaran, '$npwprd', $bln_retribusi, '$tahun_pajak', '$kode_billing', '$kd_rekening', '$nm_rekening', '$ntp', $pembayaran_ke, $tagihan, $denda, $sptpd_yg_dibayar, '$tgl_pembayaran', '-', '0')";
            $result3 = pg_query($connect, $query3);
            if (!$result3) throw new Exception('Gagal insert app_pembayaran_retribusi');

            // update table qris_va_spt
            $query4 = "UPDATE qris_va_spt SET status = '1', transaction_date = '$date' 
                WHERE invoice_id = '$invoiceNumber'";
            $result4 = pg_query($connect, $query4);
            if (!$result4) throw new Exception('Gagal update qris_va_spt');

            // update table app_skrd
            $query5 = "UPDATE app_skrd SET status_bayar = '1', status_lunas = '1'
                WHERE kd_billing = '$kode_billing'";
            $result5 = pg_query($connect, $query5);
            if (!$result5) throw new Exception('Gagal update app_skrd');

            // insert log_payment_qris
            $query_log = "INSERT INTO log_payment_qris (kode_billing, type, transaction_date, transaction_status, transaction_amount, transaction_reference, payment_reference, merchant_mpan, rrn, invoice_number)VALUES ('$kode_billing', '$type', '$now', '$transactionStatus', '$transactionAmount', '$transactionReference', '$paymentReference', '$merchantMpan', '$rrn', '$invoiceNumber')";
            $result_log = pg_query($connect, $query_log);
            if (!$result_log) throw new Exception('Gagal insert log_payment_qris');

            // Jika semua sukses, commit
            pg_query($connect, "COMMIT");

        } catch (Exception $e) {
            // Jika ada error, rollback
            pg_query($connect, "ROLLBACK");
            echo "Transaksi gagal: " . $e->getMessage();
        }


        $response_code	 = "0000";
        $message	       = "Success"; 
    }
}

 
$arr_stat = array();
$arr_stat['response_code'] = $response_code;
$arr_stat['response_message'] = $message;

 
echo json_encode($arr_stat,JSON_UNESCAPED_SLASHES);
