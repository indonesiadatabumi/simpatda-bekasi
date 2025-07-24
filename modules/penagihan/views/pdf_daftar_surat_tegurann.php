<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
require_once APPPATH.'libraries/fpdf/table/header_footer.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
					
if(empty($linespace)) $linespace = 5;

$arr_data = $model->get_header();
if(!empty($arr_data)) {


$pdf = new fpdf_table('L','mm','A4'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetFont('Arial','',8);
$pdf->AddPage();

$pdf->SetStyle("sb","arial","B",9,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",12,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");
$pdf->SetStyle("s","arial","",6,"0,0,0");

$logo = "assets/".$pemda->dapemda_logo_path;
$pdf->Image($logo,10,10,13);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,"PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2),'','','L').
						$pdf->Cell(80,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,strtoupper($pemda->nama_dinas),'','','L').
						$pdf->Cell(80,3,"",'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,ucwords(strtolower($pemda->dapemda_lokasi)),'','','L').
						$pdf->Cell(80,3,"",'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);
					
$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,4,"",'','','C').
						$pdf->Cell(50,3,"Telp. " .$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax,'','','L').
						$pdf->Cell(80,3,"",'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);
					
$pdf->MultiCell(182,4,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,4,"",'','','C').
						$pdf->Cell(50,3,strtoupper($pemda->dapemda_ibu_kota),'','','L').
						$pdf->SetFont('Arial','B',11).$pdf->Cell(140,4,"DAFTAR TEGURAN ".strtoupper($jenis_pajak->ref_jenparet_ket),'','','C'),'','','',0);
						
$bulan = (strlen($this->input->get('bulan') == 1) ? "0".$this->input->get('bulan') : $this->input->get('bulan'));
$pdf->MultiCell(182,8,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,4,"",'','','C').
						$pdf->Cell(50,3,"",'','','L').
					//	$pdf->SetFont('Arial','B',10).$pdf->Cell(140,4,"MASA PAJAK : ". strtoupper(getNamaBulan($bulan))."   TAHUN : ".$this->input->get("tahun"),
					//'','','C'),'','','',0);
					$pdf->SetFont('Arial','B',10).$pdf->Cell(140,4,"   TAHUN : ".$this->input->get("tahun"),
					'','','C'),'','','',0);

if($kecamatan != "" || $kecamatan != null) {
	$pdf->MultiCell(182,3,$pdf->SetFont('Arial','',9).$pdf->Cell(50,2,"KECAMATAN : ". strtoupper($kecamatan),'','','C'),'','','',0);
}

$kolom = 8;
$pdf->tbInitialize($kolom, true, true);
$pdf->tbSetTableType($table_default_tbl_type);
for($i=0; $i<$kolom; $i++) $header[$i] = $table_default_header_type;

for($i=0; $i<$kolom; $i++) {
	//$ket[$i] = $table_noborder;
	$th1[$i] = $table_default_tblheader_type;
	$th2[$i] = $table_default_tblheader_type;
}
$th1[0]['WIDTH'] = 10;
$th1[1]['WIDTH'] = 20;
$th1[2]['WIDTH'] = 20;
$th1[3]['WIDTH'] = 50;
$th1[4]['WIDTH'] = 80;
$th1[5]['WIDTH'] = 30;
$th1[6]['WIDTH'] = 20;
$th1[7]['WIDTH'] = 30;

$th1[0]['TEXT'] = "<b>No.</b>";
$th1[1]['TEXT'] = "<b>Jatuh Tempo</b>";
$th1[2]['TEXT'] = "<b>Nomor</b>";
$th1[3]['TEXT'] = "<b>Nama</b>";
$th1[4]['TEXT'] = "<b>Alamat</b>";
$th1[5]['TEXT'] = "<b>NPWPD</b>";
$th1[6]['TEXT'] = "<b>Ketetapan</b>";
$th1[7]['TEXT'] = "<b>Pajak (Rp)</b>";

$th1[0]['LN_SIZE'] = 4;
$th1[0]['BRD_TYPE'] = 'LT';
$th1[1]['BRD_TYPE'] = 'LT';
$th1[2]['BRD_TYPE'] = 'LT';
$th1[3]['BRD_TYPE'] = 'LT';
$th1[4]['BRD_TYPE'] = 'LT';
$th1[5]['BRD_TYPE'] = 'LT';
$th1[6]['BRD_TYPE'] = 'LT';
$th1[7]['BRD_TYPE'] = 'LRT';

$arHeader = array(
	$th1
);

$pdf->tbSetHeaderType($arHeader, true);
$pdf->tbDrawHeader();

$datax = array();
for($i=0; $i<$kolom; $i++) $datax[$i] = $table_default_tbldata_type;

$pdf->tbSetDataType($datax);



$total = 0;
$counter = 1;
$data1 = array();

foreach($arr_data as $k => $v) {
	//prepare data
	$pajak = 0;	
	$total_denda = 0;
	$total_kenaikan = 0;
	$total_bunga = 0;
	
	
	if ($v['ketspt_singkat'] == "STPD") {
		$detail = $model->get_detail($v['wp_wr_id']);
		foreach ($detail as $key => $val) {
			$total_bunga += $val['spt_dt_bunga'];
			$total_denda += $val['spt_dt_denda'];
			$total_kenaikan += $val['spt_dt_kenaikan'];
		}
		$pajak = $v['spt_pajak'] + $total_bunga + $total_denda + $total_kenaikan;
	} else {
		$pajak = $v['spt_pajak'];
	}
	
	$alamat_lengkap = str_replace("\n","",$v['wp_wr_almt']) . ' Kec. ' . $v['wp_wr_camat'];
				
	$data1[0]['TEXT'] = $counter . ".";
	$data1[1]['TEXT'] = format_tgl($v['jatuh_tempo']);
	$data1[2]['TEXT'] = $v['spt_nomor'];
	$data1[3]['TEXT'] = "" . $v['wp_wr_nama'];
	$data1[4]['TEXT'] = "" . strtoupper($alamat_lengkap);
	$data1[5]['TEXT'] = "" . $v['npwprd'];
	$data1[6]['TEXT'] = $v['ketspt_singkat'];
	$data1[7]['TEXT'] = format_currency($pajak);

	$data1[0]['T_ALIGN'] = 'L';$data1[1]['T_ALIGN'] = 'C';$data1[2]['T_ALIGN'] = 'L';$data1[3]['T_ALIGN'] = 'L';$data1[4]['T_ALIGN'] = 'L';$data1[5]['T_ALIGN'] = 'C';$data1[7]['T_ALIGN'] = 'R';
	$data1[0]['BRD_TYPE'] = 'LT';
	$data1[1]['BRD_TYPE'] = 'LT';
	$data1[2]['BRD_TYPE'] = 'LT';
	$data1[3]['BRD_TYPE'] = 'LT';
	$data1[4]['BRD_TYPE'] = 'LT';
	$data1[5]['BRD_TYPE'] = 'LT';
	$data1[6]['BRD_TYPE'] = 'LT';
	$data1[7]['BRD_TYPE'] = 'LRT';
	$data1[0]['T_SIZE'] = 8;$data1[1]['T_SIZE'] = 8;$data1[2]['T_SIZE'] = 8;$data1[3]['T_SIZE'] = 8;$data1[4]['T_SIZE'] = 8;$data1[5]['T_SIZE'] = 8;
	$data1[6]['T_SIZE'] = 8;$data1[7]['T_SIZE'] = 8;
	$data1[0]['LN_SIZE'] = $linespace;$data1[1]['LN_SIZE'] = $linespace;$data1[2]['LN_SIZE'] = $linespace;$data1[3]['LN_SIZE'] = $linespace;
	$data1[4]['LN_SIZE'] = $linespace;$data1[5]['LN_SIZE'] = $linespace;$data1[6]['LN_SIZE'] = $linespace;$data1[7]['LN_SIZE'] = $linespace;
	
	$pdf->tbDrawData($data1);
	
	$total += $pajak;
	$counter++;
}


$tbl3[0]['TEXT'] = "<b>J U M L A H</b>";
$tbl3[7]['TEXT'] = format_currency($total);
$tbl3[0]['COLSPAN'] = 7;
$tbl3[0]['T_SIZE'] = 8;$tbl3[7]['T_SIZE'] = 8;
$tbl3[0]['T_ALIGN'] = 'C';$tbl3[7]['T_ALIGN'] = 'R';
$tbl3[0]['BRD_TYPE'] = 'LT';$tbl3[7]['BRD_TYPE'] = 'LRT';
$tbl3[0]['LN_SIZE'] = 6;$tbl3[7]['LN_SIZE'] = 6;
$pdf->tbDrawData($tbl3);

$data3 = array();
$data3[0]['TEXT'] = "";
$data3[0]['COLSPAN'] = 8;
$data3[0]['BRD_TYPE'] = 'T';
$pdf->tbDrawData($data3);

$pdf->tbOuputData();

//mengetahui dan diperiksa
//Tanda Tangan
$kols = 3;
$pdf->tbInitialize($kols, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($c=0; $c<$kols; $c++) $width[$c] = $table_default_datax_type;

$width[0]['WIDTH'] = 94;
$width[1]['WIDTH'] = 94;
$width[2]['WIDTH'] = 89;

$pdf->tbSetHeaderType($width);

for($d=0; $d<$kols; $d++) {
	$ttd1[$d] = $table_default_ttd_type;
	$ket[$d] = $table_default_ttd_type;
}

$ttd1[0]['TEXT'] = "Mengetahui,";
$ttd1[1]['TEXT'] = "Diperiksa Oleh,";
$ttd1[2]['TEXT'] = $pemda->dapemda_nm_dati2.", ". format_tgl($_GET['tgl_cetak'],false,true);
$ttd1[2]['T_ALIGN'] = 'L';
$pdf->tbDrawData($ttd1);

if ($this->session->userdata('USER_SPT_CODE') == "10") {
	$ttd1[0]['TEXT'] = ($mengetahui->pejda_kode != '01') ? "an.".$this->config->item('nama_jabatan_kepala_dinas')."\n".$mengetahui->ref_japeda_nama:"" . $mengetahui->ref_japeda_nama;
} else {
	$ttd1[0]['TEXT'] = $mengetahui->ref_japeda_nama;
}

$ttd1[1]['TEXT'] = "" . $diperiksa->ref_japeda_nama;
$ttd1[2]['TEXT'] = "";
$pdf->tbDrawData($ttd1);

$ttd1[0]['TEXT'] = "";
$ttd1[1]['TEXT'] = "";
$ttd1[2]['TEXT'] = "\nN a m a            : " . $this->session->userdata('USER_FULL_NAME');
$ttd1[2]['TEXT'] .= "\nJ a b a t a n      : " . $this->session->userdata('USER_JABATAN_NAME');
$pdf->tbDrawData($ttd1);

$ttd1[0]['TEXT'] = "";
$ttd1[1]['TEXT'] = "";
$ttd1[2]['TEXT'] = "";
$pdf->tbDrawData($ttd1);
$pdf->tbDrawData($ttd1);

$ttd1[0]['TEXT'] = "<nu>  " . $mengetahui->pejda_nama . "  </nu>";
$ttd1[1]['TEXT'] = "<nu>  " . $diperiksa->pejda_nama . "  </nu>";
$ttd1[2]['TEXT'] = "Tanda Tangan : . . . . . . . . . . . . . . . . . . . . .";
$pdf->tbDrawData($ttd1);

$ttd1[0]['TEXT'] = "" . $mengetahui->ref_pangpej_ket;
$ttd1[1]['TEXT'] = "" . $diperiksa->ref_pangpej_ket;
$ttd1[2]['TEXT'] = "";
$pdf->tbDrawData($ttd1);

$ttd1[0]['TEXT'] = "NIP. " . $mengetahui->pejda_nip;
$ttd1[1]['TEXT'] = "NIP. " . $diperiksa->pejda_nip;
$ttd1[2]['TEXT'] = "";
$pdf->tbDrawData($ttd1);

$pdf->tbOuputData();

$pdf->Output();

} else {
	echo "<script type='text/javascript'>alert('Data tidak ditemukan.');</script>";
}

?>