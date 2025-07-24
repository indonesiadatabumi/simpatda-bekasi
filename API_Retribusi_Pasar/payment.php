<?php
require "header.php";
require_once "koneksi.php";
require_once "input.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);

$npwrd = $data['npwrd'];
$bln_retribusi = $data['bln_retribusi'];
$thn_retribusi = $data['thn_retribusi'];
$total_bayar = $data['total_bayar'];

$query = "SELECT a.npwrd, a.kd_billing, a.thn_retribusi, a.kd_rekening, a.nm_rekening, a.tgl_skrd, a.tgl_penetapan, b.total_retribusi FROM app_skrd as a left join app_nota_perhitungan as b on a.id_skrd=b.fk_skrd WHERE a.npwrd= '$npwrd' AND a.bln_retribusi= '$bln_retribusi' AND a.thn_retribusi= '$thn_retribusi' AND b.total_retribusi= $total_bayar ";
$result = pg_query($connect, $query);
$row = pg_fetch_object($result);
pg_free_result($result);
$npwprd = $row->npwrd;
$kode_billing = $row->kd_billing;
$tahun_pajak = $row->thn_retribusi;
$pembayaran_ke = 1;
$kd_rekening = $row->kd_rekening;
$nm_rekening = $row->nm_rekening;
$masa_awal = $row->tgl_skrd;
$masa_akhir = $row->tgl_penetapan;
$tagihan = $row->total_retribusi;
$denda = 0;
$sptpd_yg_dibayar = $total_bayar;
$tgl_pembayaran = date('Y-m-d H:i:s');
$tgl_rekam_bayar = date('Y-m-d H:i:s');
$nip_rekam_byr = "40";
$ntp = "1667184744355";
$tgl_ntp = date('Y-m-d H:i:s');

$query2 = "INSERT INTO payment.pembayaran_sptpd (npwprd, kode_billing, tahun_pajak, pembayaran_ke, kd_rekening, nm_rekening, masa_awal, masa_akhir, tagihan, denda, sptpd_yg_dibayar, tgl_pembayaran, tgl_rekam_byr, nip_rekam_byr, ntp, tgl_ntp, status_reversal, tgl_reversal, nip_reversal) VALUES ('$npwrd', '$kode_billing', '$tahun_pajak', $pembayaran_ke, '$kd_rekening', '$nm_rekening', '$masa_awal', '$masa_akhir', $tagihan, $denda, $sptpd_yg_dibayar, '$tgl_pembayaran', '$tgl_rekam_bayar', '$nip_rekam_byr', '$ntp', '$tgl_ntp', null, null, null)";
$result2 = pg_query($connect, $query2);
pg_free_result($result2);

$query3 = "UPDATE app_skrd SET status_bayar = '1', status_lunas = '1' WHERE kd_billing= '$kode_billing'";
$result3 = pg_query($connect, $query3);
pg_free_result($result3);

$data = [
    'npwrd' => $npwrd,
    'bln_retribusi' => $bln_retribusi,
    'thn_retribusi' => $thn_retribusi,
    'total_bayar' => $total_bayar
];

$response = [
    'status' => 'Sukses',
    'data' => $data
];

echo json_encode($response);