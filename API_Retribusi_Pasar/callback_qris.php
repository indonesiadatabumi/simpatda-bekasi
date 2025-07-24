<?php
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";

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

// cek generate qris
$query_cek_qris = "SELECT kode_billing, id_user, status_bayar FROM app_qris_retribusi
                WHERE invoice_id = '$invoiceNumber'";
$result_cek_qris = pg_query($connect, $query_cek_qris);
$row_cek_qris = pg_fetch_object($result_cek_qris);
pg_free_result($result_cek_qris);
if ($row_cek_qris == null) {
    $response_code     = "0014";
    $message         = "Tagihan Tidak Ditemukan";
} else {
    if ($row_cek_qris->status_bayar == '1') {
        $response_code     = "0014";
        $message         = "Pajak sudah terbayar";
    } else {
        $kode_billing = $row_cek_qris->kode_billing;
        $id_user = $row_cek_qris->id_user;
        $query = "SELECT a.npwrd, a.bln_retribusi, a.thn_retribusi, a.kd_billing, b.kd_rekening, b.nm_rekening, b.total_retribusi FROM app_skrd_pasar AS a 
        LEFT JOIN app_nota_perhitungan_pasar AS b ON a.id_skrd=b.fk_skrd AND a.npwrd=b.npwrd
        WHERE a.kd_billing= '$kode_billing'";
        $result = pg_query($connect, $query);
        $row = pg_fetch_object($result);
        pg_free_result($result);
        $npwrd = $row->npwrd;
        $bln_retribusi = $row->bln_retribusi;
        $thn_retribusi = $row->thn_retribusi;
        $kd_billing = $row->kd_billing;
        $kd_rekening = $row->kd_rekening;
        $nm_rekening = $row->nm_rekening;
        $ntpd = date('YmdHis');
        $pembayaran_ke = '1';
        $total_retribusi = $row->total_retribusi;
        $denda = 0;
        $total_bayar = $row->total_retribusi;
        $tgl_pembayaran = $now;

        // Mulai transaksi
        pg_query($connect, "BEGIN");

        try {
            // insert ke log_payment_qris
            $query_log = "INSERT INTO log_payment_qris (kode_billing, type, transaction_date, transaction_status, transaction_amount, transaction_reference, payment_reference, merchant_mpan, rrn, invoice_number)VALUES ('$kd_billing', '$type', '$now', '$transactionStatus', '$transactionAmount', '$transactionReference', '$paymentReference', '$merchantMpan', '$rrn', '$invoiceNumber')";
            $result_log = pg_query($connect, $query_log);
            if (!$result_log) throw new Exception("Gagal insert log_payment_qris");
            pg_free_result($result_log);

            // insert ke payment_retribusi_pasar
            $query_payment = "INSERT INTO payment_retribusi_pasar (npwrd, bln_retribusi, thn_retribusi, kd_billing, kd_rekening, nm_rekening, ntpd, pembayaran_ke, total_retribusi, denda, total_bayar, tgl_pembayaran, nip_rekam_bayar, status_reversal, id_user)VALUES ('$npwrd', $bln_retribusi, $thn_retribusi, '$kd_billing', '$kd_rekening', '$nm_rekening', '$ntpd', $pembayaran_ke, $total_retribusi, $denda, $total_bayar, '$tgl_pembayaran', '-', '0', '$id_user')";
            $result_payment = pg_query($connect, $query_payment);
            if (!$result_payment) throw new Exception("Gagal insert payment_retribusi_pasar");
            pg_free_result($result_payment);

            // update app_qris_retribusi
            $query_update_status_qris1 = "UPDATE app_qris_retribusi SET status_bayar = '1', transaction_date = '$now' 
                WHERE invoice_id = '$invoiceNumber'";
            $result_update_status_qris1 = pg_query($connect, $query_update_status_qris1);
            if (!$result_update_status_qris1) throw new Exception("Gagal update app_qris_retribusi");
            pg_free_result($result_update_status_qris1);

            // update qris_va_spt
            $query_update_status_qris2 = "UPDATE qris_va_spt SET status = '1', transaction_date = '$now' 
                WHERE invoice_id = '$invoiceNumber'";
            $result_update_status_qris2 = pg_query($connect, $query_update_status_qris2);
            if (!$result_update_status_qris2) throw new Exception("Gagal update qris_va_spt");

            // update app_skrd_pasar
            $query_update_status_skrd = "UPDATE app_skrd_pasar SET status_bayar = '1', status_lunas = '1' 
                WHERE kd_billing = '$kd_billing'";
            $result_update_status_skrd = pg_query($connect, $query_update_status_skrd);
            if (!$result_update_status_skrd) throw new Exception("Gagal update app_skrd_pasar");
            pg_free_result($result_update_status_skrd);

            // Jika semua berhasil
            pg_query($connect, "COMMIT");
            
            $response_code     = "0000";
            $message           = "Success";

        } catch (Exception $e) {
            pg_query($connect, "ROLLBACK");
            echo "Transaksi gagal: " . $e->getMessage() . "\n";
        }

    }
}


$arr_stat = array();
$arr_stat['response_code'] = $response_code;
$arr_stat['response_message'] = $message;


echo json_encode($arr_stat, JSON_UNESCAPED_SLASHES);
