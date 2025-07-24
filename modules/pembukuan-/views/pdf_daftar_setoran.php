<?php 

error_reporting(E_ERROR | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';

$line_spacing = 5;

$pdf = new pdf_usage('L','mm','A4'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 20, 5);     // Margin Left, Top, Right 2 cm
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetStyle("sb","arial","B",7,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",11,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");

//Untuk Landscape A4 set lebar 270mm
$kol = 2;
$pdf->tbInitialize($kol, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kol; $a++) $lbr[$a] = $table_default_datax_type;

$lbr[0]['WIDTH'] = 20;
$lbr[1]['WIDTH'] = 200;

$pdf->tbSetHeaderType($lbr);

for($b=0; $b<$kol; $b++) {
	$jdl[$b] = $table_default_datax_type;
}

$jdl[0]['TEXT'] = "<h1>DAFTAR</h1>";
$jdl[0]['T_ALIGN'] = 'L';
$jdl[1]['TEXT'] = "<h1>PENERIMAAN / SETORAN ". strtoupper($jenis_pajak)."</h1>";
$pdf->tbDrawData($jdl);

if ($_GET['type'] == "1") {
	$jdl[0]['TEXT'] = "";
	$jdl[1]['TEXT'] = "<h1>TANGGAL ".format_tgl($_GET['fDate'], false, true)." s.d ".format_tgl($_GET['tDate'], false, true)."</h1>";
	$pdf->tbDrawData($jdl);
} else {
	$jdl[0]['TEXT'] = "";
	$jdl[1]['TEXT'] = "<h1>BULAN ".getNamaBulan($_GET['bulan_ketetapan'])." ".$_GET['tahun_ketetapan']."</h1>";
	$pdf->tbDrawData($jdl);
}

$jdl[0]['TEXT'] = "";$jdl[1]['TEXT'] = "";
$pdf->tbDrawData($jdl);
$pdf->tbOuputData();

$kol = 10;
$pdf->tbInitialize($kol, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kol; $a++) {
	$header1[$a] = $table_default_tblheader_type;
	$header2[$a] = $table_default_tblheader_type;
}

$header1[0]['WIDTH'] = 10;
$header1[1]['WIDTH'] = 15;
$header1[2]['WIDTH'] = 40;
$header1[3]['WIDTH'] = 65;
$header1[4]['WIDTH'] = 30;
$header1[5]['WIDTH'] = 25;
$header1[6]['WIDTH'] = 25;
$header1[7]['WIDTH'] = 25;
$header1[8]['WIDTH'] = 25;
$header1[9]['WIDTH'] = 15;

$header1[0]['TEXT'] = "<b>No.</b>";
$header1[1]['TEXT'] = "<b>NOMOR SKPD</b>";
$header1[2]['TEXT'] = "<b>NAMA WAJIB PAJAK</b>";
$header1[3]['TEXT'] = "<b>ALAMAT</b>";
$header1[4]['TEXT'] = "<b>JENIS REKLAME</b>";
$header1[5]['TEXT'] = "<b>TANGGAL KETETAPAN</b>";
$header1[6]['TEXT'] = "<b>KETETAPAN</b>";
$header1[7]['TEXT'] = "<b>TANGGAL SETORAN</b>";
$header1[8]['TEXT'] = "<b>JUMLAH SETORAN (Rp)</b>";
$header1[9]['TEXT'] = "<b>KETERANGAN</b>";

$header1[0]['ROWSPAN'] = 2;$header1[1]['ROWSPAN'] = 2;$header1[3]['ROWSPAN'] = 2;$header1[4]['ROWSPAN'] = 2;$header1[5]['ROWSPAN'] = 2;
$header1[7]['ROWSPAN'] = 2;$header1[8]['ROWSPAN'] = 2;$header1[9]['ROWSPAN'] = 2;

$header1[0]['LN_SIZE'] = 5;$header1[1]['LN_SIZE'] = 5;$header1[2]['LN_SIZE'] = 5;$header1[3]['LN_SIZE'] = 5;$header1[4]['LN_SIZE'] = 5;$header1[5]['LN_SIZE'] = 5;
$header1[6]['LN_SIZE'] = 5;$header1[7]['LN_SIZE'] = 5;$header1[8]['LN_SIZE'] = 5;$header1[9]['LN_SIZE'] = 5;

$header1[0]['BRD_TYPE'] = 'LT';$header1[1]['BRD_TYPE'] = 'LT';$header1[2]['BRD_TYPE'] = 'LT';$header1[3]['BRD_TYPE'] = 'LT';$header1[4]['BRD_TYPE'] = 'LT';
$header1[5]['BRD_TYPE'] = 'LT';$header1[6]['BRD_TYPE'] = 'LT';$header1[7]['BRD_TYPE'] = 'LT';$header1[8]['BRD_TYPE'] = 'LT';$header1[9]['BRD_TYPE'] = 'LRT';

$header2[0]['TEXT'] = "";
$header2[1]['TEXT'] = "";
$header2[2]['TEXT'] = "<b>NASKAH</b>";
$header2[3]['TEXT'] = "";
$header2[4]['TEXT'] = "";
$header2[5]['TEXT'] = "";
$header2[6]['TEXT'] = "<b>(Rp)</b>";
$header2[7]['TEXT'] = "";
$header2[8]['TEXT'] = "";
$header2[9]['TEXT'] = "";

$header2[2]['BRD_TYPE'] = 'LRT';$header2[6]['BRD_TYPE'] = 'LR';

$arHeader = array(
	$header1,
	$header2
);

$pdf->tbSetHeaderType($arHeader, true);
$pdf->tbDrawHeader();

for($b=0; $b<$kol; $b++) {
	$ket[$b] = $table_default_datax_type;
	$tbl1[$b] = $table_default_tblheader_type;
	$grs[$b] = $table_default_datax_type;
	$tbl2[$b] = $table_default_datax_type;
	$tbl3[$b] = $table_default_datax_type;
}

$tbl2[0]['T_ALIGN'] = 'L';$tbl2[1]['T_ALIGN'] = 'C';$tbl2[2]['T_ALIGN'] = 'L';$tbl2[5]['T_ALIGN'] = 'C';$tbl2[6]['T_ALIGN'] = 'R';
$tbl2[7]['T_ALIGN'] = 'C';$tbl2[8]['T_ALIGN'] = 'R';$tbl2[9]['T_ALIGN'] = 'L';

$tbl2[0]['BRD_TYPE'] = 'LT';$tbl2[1]['BRD_TYPE'] = 'LT';$tbl2[2]['BRD_TYPE'] = 'LT';$tbl2[3]['BRD_TYPE'] = 'LT';$tbl2[4]['BRD_TYPE'] = 'LT';
$tbl2[5]['BRD_TYPE'] = 'LT';$tbl2[6]['BRD_TYPE'] = 'LT';$tbl2[7]['BRD_TYPE'] = 'LT';$tbl2[8]['BRD_TYPE'] = 'LT';$tbl2[9]['BRD_TYPE'] = 'LRT';

$tbl2[0]['T_SIZE'] = '8';$tbl2[1]['T_SIZE'] = '8';$tbl2[2]['T_SIZE'] = '8';$tbl2[3]['T_SIZE'] = '8';$tbl2[4]['T_SIZE'] = '8';$tbl2[5]['T_SIZE'] = '8';
$tbl2[6]['T_SIZE'] = '8';$tbl2[7]['T_SIZE'] = '8';$tbl2[8]['T_SIZE'] = '8';$tbl2[9]['T_SIZE'] = '8';

$tbl2[0]['LN_SIZE'] = $line_spacing;$tbl2[1]['LN_SIZE'] = $line_spacing;$tbl2[2]['LN_SIZE'] = $line_spacing;$tbl2[3]['LN_SIZE'] = $line_spacing;
$tbl2[4]['LN_SIZE'] = $line_spacing;$tbl2[5]['LN_SIZE'] = $line_spacing;$tbl2[6]['LN_SIZE'] = $line_spacing;$tbl2[7]['LN_SIZE'] = $line_spacing;
$tbl2[8]['LN_SIZE'] = $line_spacing;$tbl2[9]['LN_SIZE'] = $line_spacing;

$tbl2[0]['ROWSPAN'] = 2;$tbl2[1]['ROWSPAN'] = 2;$tbl2[3]['ROWSPAN'] = 2;$tbl2[4]['ROWSPAN'] = 2;$tbl2[5]['ROWSPAN'] = 2;
$tbl2[6]['ROWSPAN'] = 2;$tbl2[7]['ROWSPAN'] = 2;$tbl2[8]['ROWSPAN'] = 2;$tbl2[9]['ROWSPAN'] = 2;

$tbl2[0]['V_ALIGN'] = 'T';$tbl2[1]['V_ALIGN'] = 'T';$tbl2[2]['V_ALIGN'] = 'T';$tbl2[3]['V_ALIGN'] = 'T';$tbl2[4]['V_ALIGN'] = 'T';$tbl2[5]['V_ALIGN'] = 'T';
$tbl2[6]['V_ALIGN'] = 'T';$tbl2[7]['V_ALIGN'] = 'T';$tbl2[8]['V_ALIGN'] = 'T';$tbl2[9]['V_ALIGN'] = 'T';

$counter = 1;
$realisasi = 0; $pajak = 0;

if (count($dt_rows) > 0) {		
	foreach($dt_rows as $key => $val) {
		$arr_masa_pajak = explode("-", $val['stpd_periode_jual1']);
		$tbl2[0]['TEXT'] = $counter;
		$tbl2[1]['TEXT'] = $val['netapajrek_kohir'];
		$tbl2[2]['TEXT'] = $val['wp_wr_nama'];
		$tbl2[3]['TEXT'] = $val['wp_wr_almt'];		
		$tbl2[4]['TEXT'] = $val['korek_nama_detail'];
		$tbl2[5]['TEXT'] = format_tgl(format_tgl($val['netapajrek_tgl']), false, true);
		$tbl2[6]['TEXT'] = number_format($val['spt_pajak'],0,",",".");
		$tbl2[7]['TEXT'] = format_tgl(format_tgl($val['skbh_tgl']), false, true);
		$tbl2[8]['TEXT'] = number_format($val['setorpajret_dt_jumlah'],0,",",".");
		$pdf->tbDrawData($tbl2);
		
		$tbl2[0]['TEXT'] = "";
		$tbl2[1]['TEXT'] = "";
		$tbl2[2]['TEXT'] = $val['sptrek_judul'];$tbl2[2]['BRD_TYPE'] = 'LRT';
		$tbl2[3]['TEXT'] = "";
		$tbl2[4]['TEXT'] = "";
		$tbl2[5]['TEXT'] = "";
		$tbl2[6]['TEXT'] = "";
		$tbl2[7]['TEXT'] = "";
		$tbl2[8]['TEXT'] = "";
		$tbl2[9]['TEXT'] = "";
		$pdf->tbDrawData($tbl2);
	
		$realisasi += $val['setorpajret_dt_jumlah'];
		$pajak += $val['spt_pajak'];
		$counter++;
	}
}

$tbl3[0]['TEXT'] = "";
$tbl3[0]['TEXT'] = "J U M L A H";
$tbl3[6]['TEXT'] = number_format($pajak,0,",",".");
$tbl3[8]['TEXT'] = number_format($realisasi,0,",",".");
$tbl3[9]['TEXT'] = "";
$tbl3[0]['T_SIZE'] = '8';$tbl3[0]['T_TYPE'] = 'B';
$tbl3[6]['T_SIZE'] = '8';$tbl3[8]['T_SIZE'] = '8';
$tbl3[6]['T_ALIGN'] = 'R';$tbl3[0]['T_ALIGN'] = 'C';
$tbl3[8]['T_ALIGN'] = 'R';
$tbl3[0]['COLSPAN'] = 6;
$tbl3[0]['BRD_TYPE'] = 'LT';$tbl3[6]['BRD_TYPE'] = 'LT';$tbl3[7]['BRD_TYPE'] = 'LT';$tbl3[8]['BRD_TYPE'] = 'LT';$tbl3[9]['BRD_TYPE'] = 'LRT';
$pdf->tbDrawData($tbl3);

$grs[0]['TEXT'] = "";
$grs[0]['COLSPAN'] = 12;
$grs[0]['LN_SIZE'] = 6;
$grs[0]['BRD_TYPE'] = 'T';
$pdf->tbDrawData($grs);

$pdf->tbOuputData();

/*
// set page constants
// height of resulting cell
$cell_height = 4 + 1; // I have my cells at a height of five so set to six for a padding
$height_of_cell = ceil( 10 * $cell_height );
$page_height = 215.9; // mm (landscape legal)
$bottom_margin = 20; // mm

// mm until end of page (less bottom margin of 20mm)
$space_left = $page_height - $pdf->GetY(); // space left on page
$space_left -= $bottom_margin; // less the bottom margin

// test if height of cell is greater than space left
if ( $height_of_cell >= $space_left) {
	$pdf->Ln();                        

    $pdf->AddPage(); // page break.
}
  
//Tanda Tangan
if ($_GET['tandatangan'] == "1") {
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
	$ttd1[2]['TEXT'] = "Bekasi, ". format_tgl($_GET['tgl_cetak'],false,true);
	$ttd1[2]['T_ALIGN'] = 'L';
	$pdf->tbDrawData($ttd1);
	
	if ($this->session->userdata('USER_SPT_CODE') == "10" && $mengetahui->pejda_jabatan != "80") {
		$ttd1[0]['TEXT'] = ($mengetahui->pejda_kode != '01') ? "a.n. ".$this->config->item('nama_jabatan_kepala_dinas')."\n".$mengetahui->ref_japeda_nama:"" . $mengetahui->ref_japeda_nama;
	} else {
		$ttd1[0]['TEXT'] = $mengetahui->ref_japeda_nama;
	}
	
	$ttd1[1]['TEXT'] = "" . $diperiksa->ref_japeda_nama;
	$ttd1[2]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "";
	$ttd1[1]['TEXT'] = "";
	$ttd1[2]['TEXT'] = "N a m a            : " . $this->session->userdata('USER_FULL_NAME');
	$ttd1[2]['TEXT'] .= "\nJ a b a t a n      : " . $this->session->userdata('USER_JABATAN_NAME');
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "";
	$ttd1[1]['TEXT'] = "";
	$ttd1[2]['TEXT'] = "";
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
}
*/

$pdf->Output();	

?>