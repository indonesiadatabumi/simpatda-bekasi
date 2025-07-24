<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
					
if(empty($linespace)) $linespace = 4;

$pdf = new pdf_usage('P','mm','A4'); //width 190 cm
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 10, 10);     // Margin Left, Top, Right 1 cm
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetStyle("sb","arial","B",7,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("bi","arial","BI",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",12,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",9,"0,0,0");
$pdf->SetStyle("bu","arial","BU",8,"0,0,0");
$pdf->SetStyle("s","arial","",6,"0,0,0");

$kol = 11;
$pdf->tbInitialize($kol,true,true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kol; $a++) 
	$header[$a] = $table_default_header_type;

$header[0]['WIDTH'] = 10;
$header[1]['WIDTH'] = 50;
$header[2]['WIDTH'] = 16;
$header[3]['WIDTH'] = 9;
$header[4]['WIDTH'] = 16;
$header[5]['WIDTH'] = 9;
$header[6]['WIDTH'] = 16;
$header[7]['WIDTH'] = 9;
$header[8]['WIDTH'] = 16;
$header[9]['WIDTH'] = 9;
$header[10]['WIDTH'] = 30;
$pdf->tbSetHeaderType($header);

for($a=0; $a<$kol; $a++) {
	$th1[$a] = $table_header;
	$th2[$a] = $table_header;
	$ws[$a] = $table_header;
	$data1[$a] = $table_header;
	$break[$a] = $table_default_datax_type;
}

$bidus = "DAERAH";
if($this->input->get('bidus') != "") {
	$bidus = $this->adodb->GetOne("SELECT ref_kodus_nama FROM ref_kode_usaha WHERE ref_kodus_id='".$this->input->get('bidus')."'");
	$title = "Wajib Pajak $bidus";
} else {
	$title = "Jumlah Wajib Pajak";
}

$th1[0]['TEXT'] = "<h1>DAFTAR PERKEMBANGAN WAJIB PAJAK ".strtoupper($bidus)."</h1>";
$th1[0]['COLSPAN'] = 11;
$th1[0]['BRD_TYPE'] = 0;
$pdf->tbDrawData($th1);

$th1[0]['TEXT'] = "<h1>BAPENDA KOTA BEKASI</h1>";
$th1[0]['COLSPAN'] = 11;
$th1[0]['BRD_TYPE'] = 0;
$pdf->tbDrawData($th1);

$fDate = $this->input->get('fDate');
$tDate = $this->input->get('tDate');
if (empty($fDate)) {
	$fDate = date('Y-m-')."01";
	$f_date_lengkap = "";
} else {
	$fDate = format_tgl($fDate);
	$f_date_lengkap = " ".tanggal_lengkap(format_tgl($fDate));
}

if (empty($tDate)) {
	$tDate = date('Y-m-d');
	$t_date_lengkap = tanggal_lengkap(date("d-m-Y"));
} else {
	$tDate = format_tgl($tDate);
	$t_date_lengkap = tanggal_lengkap(format_tgl($tDate));
}
	
$th2[0]['TEXT'] = "<h2>( Keadaan".$f_date_lengkap." s/d ".$t_date_lengkap." )</h2>";
$th2[0]['COLSPAN'] = 11;
$th2[0]['BRD_TYPE'] = 0;
$pdf->tbDrawData($th2);

$ws[0]['TEXT'] = "";
$ws[0]['COLSPAN'] = 11;
$ws[0]['BRD_TYPE'] = 0;
$pdf->tbDrawData($ws);

$data1[0]['TEXT'] = "NO"; $data1[0]['ROWSPAN']=2; $data1[0]['BRD_TYPE'] = "LT";
if($this->input->get('bidus') == "") {
$data1[1]['TEXT'] = "PAJAK"; $data1[1]['ROWSPAN']=2; $data1[1]['BRD_TYPE'] = "LT";
} else {
	$data1[1]['TEXT'] = "UPTD"; $data1[1]['ROWSPAN']=2; $data1[1]['BRD_TYPE'] = "LT";
}

$data1[2]['TEXT'] = "$title"; $data1[2]['COLSPAN']=8; $data1[2]['BRD_TYPE'] = "LT";
$data1[10]['TEXT'] = "Keterangan"; $data1[10]['ROWSPAN']=2; $data1[10]['BRD_TYPE'] = "LTR";
$pdf->tbDrawData($data1);

$data1[2]['TEXT'] = "Keadaan s.d \nbulan lalu";$data1[2]['COLSPAN']=2; $data1[2]['BRD_TYPE'] = "LT";
$data1[4]['TEXT'] = "Penambahan \n bulan ini";$data1[4]['COLSPAN']=2; $data1[4]['BRD_TYPE'] = "LT";
$data1[6]['TEXT'] = "Penghapusan \n bulan ini";$data1[6]['COLSPAN']=2; $data1[6]['BRD_TYPE'] = "LT";
$data1[8]['TEXT'] = "Jumlah s.d \n bulan ini";$data1[8]['COLSPAN']=2; $data1[8]['BRD_TYPE'] = "LTR";
$pdf->tbDrawData($data1);

$data1[0]['TEXT'] = "1"; $data1[0]['ROWSPAN']=1; $data1[0]['BRD_TYPE'] = "LT";
$data1[1]['TEXT'] = "2"; $data1[1]['ROWSPAN']=1; $data1[0]['BRD_TYPE'] = "LT";
$data1[2]['TEXT'] = "3"; $data1[2]['BRD_TYPE'] = "LT";
$data1[4]['TEXT'] = "4"; $data1[4]['BRD_TYPE'] = "LT";
$data1[6]['TEXT'] = "5"; $data1[6]['BRD_TYPE'] = "LT";
$data1[8]['TEXT'] = "6 (3+4-5)"; $data1[8]['BRD_TYPE'] = "LT";
$data1[10]['TEXT'] = "7"; $data1[10]['BRD_TYPE'] = "LTR"; $data1[10]['ROWSPAN']=1;
$pdf->tbDrawData($data1);

$break[0]['TEXT'] = ""; $break[0]['COLSPAN'] = 11; $break[0]['BRD_TYPE'] = "T";$break[0]['LN_SIZE'] = 0.2;
$pdf->tbDrawData($break);

$no = 1;
$total_wp_sebelumnya = 0;
$total_tambah_wp = 0;
$total_kurang_wp = 0;
$total_keseluruhan = 0;

function get_jumlah_wp($bidus, $status_wp, $camat_id, $fDate, $tDate) {
	if (!isset($bidus) || !isset($status_wp))
		return 0;
		
	$sql = "SELECT count(wp_wr_id) FROM wp_wr WHERE";
	
	$sql .= " wp_wr_bidang_usaha='$bidus'";
	if ($status_wp == TRUE) {
		$sql .= " AND wp_wr_status_aktif='t'";
		
		if (isset($fDate) && isset($tDate))
			$sql .= " AND wp_wr_tgl_kartu BETWEEN '$fDate' AND '$tDate'";
		elseif (isset($fDate))
			$sql .= " AND wp_wr_tgl_kartu < '$fDate'";
	} else {
		$sql .= " AND wp_wr_status_aktif='f'";
		
		if (isset($fDate) && isset($tDate))
			$sql .= " AND wp_wr_tgl_tutup BETWEEN '$fDate' AND '$tDate'";
		elseif (isset($fDate))
			$sql .= " AND wp_wr_tgl_tutup < '$fDate'";
	}
	
	if (isset($camat_id))
		$sql .= " AND wp_wr_kd_camat='$camat_id'";
		
	return $sql;
}


function get_jumlah_wp_sebelumnya($bidus, $camat_id, $start_date, $end_date) {
	$sql = "SELECT count(wp_wr_id) FROM wp_wr WHERE";
	
	$sql .= " wp_wr_bidang_usaha='$bidus' 
				AND ((wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$start_date') 
					OR (wp_wr_status_aktif='f' AND wp_wr_tgl_tutup BETWEEN '$start_date' AND '$end_date'))";
	
	if (isset($camat_id))
		$sql .= " AND wp_wr_kd_camat='$camat_id'";
		
	return $sql;
}


//check kode jenis pajak/bidus pertama-tama
if($_GET['bidus'] != "") {
	$sqlx = $this->adodb->GetAll("SELECT * FROM kecamatan WHERE camat_kode <> '00' ORDER BY camat_kode ASC");
	foreach($sqlx as $k => $v) {
		$tambah_wp = $this->adodb->GetOne(get_jumlah_wp($this->input->get('bidus'), TRUE, $v['camat_id'], $fDate, $tDate));
		$total_tambah_wp += $tambah_wp;
		
		$kurang_wp = $this->adodb->GetOne(get_jumlah_wp($this->input->get('bidus'), FALSE, $v['camat_id'], $fDate, $tDate));
		$total_kurang_wp += $kurang_wp;
		
		$jumlah_wp = $this->adodb->GetOne(get_jumlah_wp_sebelumnya($this->input->get('bidus'), $v['camat_id'], $fDate, $tDate));
		$jumlah_wp = $jumlah_wp + $kurang_wp;
		$total_wp_sebelumnya += $jumlah_wp;
		
		$total = $jumlah_wp + $tambah_wp - $kurang_wp;
		$total_keseluruhan += $total;
		
		$data1[0]['TEXT'] = "\n".$no; $data1[0]['T_ALIGN'] = 'C';$data1[0]['BRD_TYPE'] = "L";
		$data1[1]['TEXT'] = "\n".$v['camat_nama']; $data1[1]['T_ALIGN'] = 'L';$data1[1]['BRD_TYPE'] = "L";
		$data1[2]['TEXT'] = "\n".($jumlah_wp == 0 ? "-" : $jumlah_wp);$data1[2]['T_ALIGN'] = 'R';$data1[2]['COLSPAN']=1;$data1[2]['BRD_TYPE'] = "L";
		$data1[3]['TEXT'] = "\n WP";$data1[3]['BRD_TYPE'] = "";
		$data1[4]['TEXT'] = "\n".($tambah_wp == 0 ? "-" :$tambah_wp);$data1[4]['T_ALIGN'] = 'R';$data1[4]['COLSPAN']=1;$data1[4]['BRD_TYPE'] = "L";
		$data1[5]['TEXT'] = "\n WP";$data1[5]['BRD_TYPE'] = "";
		$data1[6]['TEXT'] = "\n".($kurang_wp == 0 ? "-" : $kurang_wp);$data1[6]['T_ALIGN'] = 'R';$data1[6]['COLSPAN']=1;$data1[6]['BRD_TYPE'] = "L";
		$data1[7]['TEXT'] = "\n WP";$data1[7]['BRD_TYPE'] = "";
		$data1[8]['TEXT'] = "\n".($total == 0 ? "-" : $total);$data1[8]['T_ALIGN'] = 'R';$data1[8]['COLSPAN']=1;$data1[8]['BRD_TYPE'] = "L";
		$data1[9]['TEXT'] = "\n WP";$data1[9]['BRD_TYPE'] = "R";
		$data1[10]['TEXT'] = "\n";$data1[10]['BRD_TYPE'] = "LR";
		$pdf->tbDrawData($data1);
		
		$no++;
	}
} else {
	$jenis_pajak = array(1 => "Hotel", 2 => "Restoran", 3 => "Hiburan", 4 => "PPJ Non PLN", 5 => "Parkir", 6 => "Air Tanah");
	$bidus = array(1 => "1", 2 => "16", 3 => "11", 4 => "12", 5 => "14", 6 => "18");
	
	for ($i = 1; $i <= 6; $i++) {
		$wp_tambah = $this->adodb->GetOne(get_jumlah_wp($bidus[$i], TRUE, NULL, $fDate, $tDate));
		$total_tambah_wp += $wp_tambah;
		
		$wp_kurang = $this->adodb->GetOne(get_jumlah_wp($bidus[$i], FALSE, NULL, $fDate, $tDate));
		$total_kurang_wp += $wp_kurang;
		
		$wp_sebelumnya = $this->adodb->GetOne(get_jumlah_wp($bidus[$i], TRUE, NULL, $fDate, NULL));
		$wp_sebelumnya = $wp_sebelumnya + $wp_kurang;
		$total_wp_sebelumnya += $wp_sebelumnya;
		
		$wp_total = $wp_sebelumnya + $wp_tambah - $wp_kurang;
		$total_keseluruhan += $wp_total;
		
		$data1[0]['TEXT'] = "\n$no"; $data1[0]['T_ALIGN'] = 'C';$data1[0]['BRD_TYPE'] = "L";
		$data1[1]['TEXT'] = "\n".$jenis_pajak[$i]; $data1[1]['T_ALIGN'] = 'L';$data1[1]['BRD_TYPE'] = "L";
		$data1[2]['TEXT'] = "\n".($wp_sebelumnya == 0 ? "-" : $wp_sebelumnya);$data1[2]['T_ALIGN'] = 'R';$data1[2]['COLSPAN']=1;$data1[2]['BRD_TYPE'] = "L";
		$data1[3]['TEXT'] = "\n WP";$data1[3]['BRD_TYPE'] = "";
		$data1[4]['TEXT'] = "\n".($wp_tambah == 0 ? "-" :$wp_tambah);$data1[4]['T_ALIGN'] = 'R';$data1[4]['COLSPAN']=1;$data1[4]['BRD_TYPE'] = "L";
		$data1[5]['TEXT'] = "\n WP";$data1[5]['BRD_TYPE'] = "";
		$data1[6]['TEXT'] = "\n".($wp_kurang == 0 ? "-" : $wp_kurang);$data1[6]['T_ALIGN'] = 'R';$data1[6]['COLSPAN']=1;$data1[6]['BRD_TYPE'] = "L";
		$data1[7]['TEXT'] = "\n WP";$data1[7]['BRD_TYPE'] = "";
		$data1[8]['TEXT'] = "\n".($wp_total == 0 ? "-" : $wp_total);$data1[8]['T_ALIGN'] = 'R';$data1[8]['COLSPAN']=1;$data1[8]['BRD_TYPE'] = "L";
		$data1[9]['TEXT'] = "\n WP";$data1[9]['BRD_TYPE'] = "R";
		$data1[10]['TEXT'] = "\n";$data1[10]['BRD_TYPE'] = "LR";
		$pdf->tbDrawData($data1);
		
		$no++;
	}
}

$data1[0]['TEXT'] = "\n";$data1[0]['BRD_TYPE'] = "L";
$data1[1]['TEXT'] = "\n";$data1[1]['BRD_TYPE'] = "L";
$data1[2]['TEXT'] = "\n";$data1[2]['BRD_TYPE'] = "L";
$data1[3]['TEXT'] = "\n";$data1[3]['BRD_TYPE'] = "";
$data1[4]['TEXT'] = "\n";$data1[4]['BRD_TYPE'] = "L";
$data1[5]['TEXT'] = "\n";$data1[5]['BRD_TYPE'] = "";
$data1[6]['TEXT'] = "\n";$data1[6]['BRD_TYPE'] = "L";
$data1[7]['TEXT'] = "\n";$data1[7]['BRD_TYPE'] = "";
$data1[8]['TEXT'] = "\n";$data1[8]['BRD_TYPE'] = "L";
$data1[9]['TEXT'] = "\n";$data1[9]['BRD_TYPE'] = "R";
$data1[10]['TEXT'] = "\n";$data1[10]['BRD_TYPE'] = "LR";
$pdf->tbDrawData($data1);

$data1[0]['TEXT'] = "Jumlah Total";$data1[0]['BRD_TYPE'] = "LTB";$data1[0]['COLSPAN'] = 2;$data1[0]['LN_SIZE'] = 8;
$data1[2]['TEXT'] = ($total_wp_sebelumnya == 0 ? "-" : $total_wp_sebelumnya);$data1[2]['BRD_TYPE'] = "LT";$data1[2]['LN_SIZE'] = 8;
$data1[3]['TEXT'] = " WP";$data1[3]['BRD_TYPE'] = "T";$data1[3]['LN_SIZE'] = 8;
$data1[4]['TEXT'] = ($total_tambah_wp == 0 ? "-" : $total_tambah_wp);$data1[4]['BRD_TYPE'] = "LT";$data1[4]['LN_SIZE'] = 8;
$data1[5]['TEXT'] = " WP";$data1[5]['BRD_TYPE'] = "T";$data1[5]['LN_SIZE'] = 8;
$data1[6]['TEXT'] = ($total_kurang_wp == 0 ? "-" : $total_kurang_wp);$data1[6]['BRD_TYPE'] = "LT";$data1[6]['LN_SIZE'] = 8;
$data1[7]['TEXT'] = " WP";$data1[7]['BRD_TYPE'] = "T";$data1[7]['LN_SIZE'] = 8;
$data1[8]['TEXT'] = ($total_keseluruhan == 0 ? "-" : $total_keseluruhan);$data1[8]['BRD_TYPE'] = "LT";$data1[8]['LN_SIZE'] = 8;
$data1[9]['TEXT'] = " WP";$data1[9]['BRD_TYPE'] = "RT";$data1[9]['LN_SIZE'] = 8;
$data1[10]['TEXT'] = ""; $data1[10]['BRD_TYPE'] = "LRT";$data1[10]['ROWSPAN']=1;$data1[10]['COLSPAN']=1;$data1[10]['LN_SIZE'] = 8;
$pdf->tbDrawData($data1);

$break[0]['TEXT'] = ""; $break[0]['COLSPAN'] = 11; $break[0]['BRD_TYPE'] = "T";$break[0]['LN_SIZE'] = 5;
$pdf->tbDrawData($break);
$pdf->tbOuputData();

//bagian tanda tangan
$klm = 2;
$pdf->tbInitialize($klm, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($c=0;$c<$klm;$c++) $hdrt[$c] = $table_default_header_type;

for($c=0;$c<$klm;$c++) {
	$ac[$c] = $table_default_header_type;
}
$ac[0]['WIDTH'] = 95;$ac[1]['WIDTH'] = 95;

$arhdr = array($ac);
$pdf->tbSetHeaderType($arhdr,true);

$dtxs = array();
for($c=0;$c<$klm;$c++) $dtxs[$c] = $table_default_datax_type;

$pdf->tbSetDataType($dtxs);

for($c=0;$c<$klm;$c++) {
	$ttd1[$c] = $table_default_ttd_type;
	$ttd2[$c] = $table_default_ttd_type;
}

$ttd1[0]['TEXT'] = "";
$ttd1[1]['TEXT'] = "Bekasi, ". tanggal_lengkap($this->input->get('tgl_cetak'))."\n\n";
$pdf->tbDrawData($ttd1);

if ($this->input->get('mengetahui') != "0" && $this->input->get('pemeriksa') != "0") {
	$ttd1[0]['TEXT'] = "Mengetahui,";
	$ttd1[1]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	
	if ($this->session->userdata('USER_SPT_CODE') == "10" && $mengetahui->pejda_jabatan != "80") {
		$ttd1[0]['TEXT'] = "a.n. ".$this->config->item('nama_jabatan_kepala_dinas')."\n";
		$ttd1[0]['TEXT'] .= $mengetahui->ref_japeda_nama;
		$ttd1[1]['TEXT'] = "\n".$pemeriksa->ref_japeda_nama;
	} else {
		$ttd1[0]['TEXT'] = $mengetahui->ref_japeda_nama;
		$ttd1[1]['TEXT'] = $pemeriksa->ref_japeda_nama;
	}
	$pdf->tbDrawData($ttd1);
		
	$ttd2[0]['TEXT'] = "";
	$ttd2[1]['TEXT'] = "";
	$pdf->tbDrawData($ttd2);
	$pdf->tbDrawData($ttd2);
	$pdf->tbDrawData($ttd2);
	$pdf->tbDrawData($ttd2);
	
	$ttd1[0]['TEXT'] = "<nu>  ".$mengetahui->pejda_nama . "  </nu>";
	$ttd1[1]['TEXT'] = "<nu>  ".$pemeriksa->pejda_nama . "  </nu>";
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = $mengetahui->ref_pangpej_ket;
	$ttd1[1]['TEXT'] = $pemeriksa->ref_pangpej_ket;
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "NIP. " . $mengetahui->pejda_nip;
	$ttd1[1]['TEXT'] = "NIP. " . $pemeriksa->pejda_nip;
	$pdf->tbDrawData($ttd1);
}

$pdf->tbOuputData();

$pdf->Output();

?>