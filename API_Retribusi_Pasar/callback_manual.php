<?php
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";
require_once "fungsi.php";

$id_user = $data ['id_user'];
$create_date = $data ['create_date'];
$now = date('Y-m-d H:i:s');
// cek qris
$query = "SELECT kode_billing, invoice_id FROM app_qris_retribusi WHERE id_user = '$id_user' AND create_date = '$create_date' AND status_bayar = '0'";
$result = pg_query($connect, $query);
while ($row = pg_fetch_array($result)) {
    $kode_billing = $row['kode_billing'];
    $qris_id = $row['invoice_id'];
    $dataMsisdn = getPhoneNo($id_user);
    $chekcStatusQris = checkBayar($qris_id, $dataMsisdn['msisdn']);
    
    if ($chekcStatusQris->MSG->isPaid == true) {
        $query_skrd = "SELECT a.npwrd, a.bln_retribusi, a.thn_retribusi, a.kd_billing, b.kd_rekening, b.nm_rekening, b.total_retribusi FROM app_skrd_pasar AS a 
        LEFT JOIN app_nota_perhitungan_pasar AS b ON a.id_skrd=b.fk_skrd AND a.npwrd=b.npwrd
        WHERE a.kd_billing= '$kode_billing'";
        
        $result_skrd = pg_query($connect, $query_skrd);
        if ($result_skrd && pg_num_rows($result_skrd) > 0){
            $row_skrd = pg_fetch_object($result_skrd);
            pg_free_result($result_skrd);
            $npwrd = $row_skrd->npwrd;
            $bln_retribusi = $row_skrd->bln_retribusi;
            $thn_retribusi = $row_skrd->thn_retribusi;
            $kd_billing = $row_skrd->kd_billing;
            $kd_rekening = $row_skrd->kd_rekening;
            $nm_rekening = $row_skrd->nm_rekening;
            $ntpd = date('YmdHis');
            $pembayaran_ke = '1';
            $total_retribusi = $row_skrd->total_retribusi;
            $denda = 0;
            $total_bayar = $row_skrd->total_retribusi;
            $tgl_pembayaran = $now;
            
            //insert table payment_retribusi_pasar
            $query_payment = "INSERT INTO payment_retribusi_pasar (npwrd, bln_retribusi, thn_retribusi, kd_billing, kd_rekening, nm_rekening, ntpd, pembayaran_ke, total_retribusi, denda, total_bayar, tgl_pembayaran, nip_rekam_bayar, status_reversal, id_user) VALUES ('$npwrd', $bln_retribusi, $thn_retribusi, '$kd_billing', '$kd_rekening', '$nm_rekening', '$ntpd', $pembayaran_ke, $total_retribusi, $denda, $total_bayar, '$tgl_pembayaran', '-', '0', '$id_user')";
            $result_payment = pg_query($connect, $query_payment);
            pg_free_result($result_payment);
    
            //update status qris tabel app_qris_retribusi
            $query_update_status_qris = "UPDATE app_qris_retribusi SET status_bayar = '1', transaction_date = '$now' 
                    WHERE invoice_id= '$qris_id'";
            $result_update_status_qris = pg_query($connect, $query_update_status_qris);
            pg_free_result($result_update_status_qris);
    
            //update status qris tabel qris_va_spt
            $query_update_status_qris = "UPDATE qris_va_spt SET status = '1', transaction_date = '$now' 
                    WHERE invoice_id= '$qris_id'";
            $result_update_status_qris = pg_query($connect, $query_update_status_qris);
    
            //update status bayar tabel app_skrd
            $query_upadate_status_skrd = "UPDATE app_skrd_pasar SET status_bayar = '1', status_lunas = '1' 
                    WHERE kd_billing= '$kd_billing'";
            $result_upadate_status_skrd = pg_query($connect, $query_upadate_status_skrd);
            pg_free_result($result_upadate_status_skrd);
    
            echo $kode_billing." berhasil dilunaskan \n";
        }else {
            echo "Data tidak ditemukan untuk kode billing: " . $kode_billing . "\n";
        }
    }else {
        echo $kode_billing." belum lunas \n";
    }
    // $jsonCheckStatus = json_decode($chekcStatusQris);

    // $arrResponse = array();
    // $arrResponse['status'] = $chekcStatusQris->STATUS;
    // $arrResponse['message'] = $chekcStatusQris->CODE;
    // $arrResponse['data'] = $chekcStatusQris->MSG;
}

// echo json_encode($arrResponse, JSON_UNESCAPED_SLASHES);