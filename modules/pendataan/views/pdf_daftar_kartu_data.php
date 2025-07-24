<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH . 'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
// require_once APPPATH . 'libraries/fpdf/table/header_footer.inc';

//Table Defintion File
require_once APPPATH . 'libraries/fpdf/table/table_def.inc';

$line_spacing = 5;

$pdf = new FPDF_TABLE('L', 'mm', 'A4'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
//$pdf->SetMargins(10, 10, 10);     // Margin Left, Top, Right 2 cm
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetStyle("sb", "arial", "B", 7, "0,0,0");
$pdf->SetStyle("b", "arial", "B", 8, "0,0,0");
$pdf->SetStyle("h1", "arial", "B", 12, "0,0,0");
$pdf->SetStyle("h2", "arial", "B", 10, "0,0,0");
$pdf->SetStyle("nu", "arial", "U", 8, "0,0,0");

//Untuk Landscape A4 set lebar 270mm
$kol = 10;
$pdf->tbInitialize($kol, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for ($a = 0; $a < $kol; $a++) $lbr[$a] = $table_default_datax_type;

$lbr[0]['WIDTH'] = 8;
$lbr[1]['WIDTH'] = 20;
$lbr[2]['WIDTH'] = 15;
$lbr[3]['WIDTH'] = 50;
$lbr[4]['WIDTH'] = 60;
$lbr[5]['WIDTH'] = 30;
$lbr[6]['WIDTH'] = 25;
$lbr[7]['WIDTH'] = 10;
$lbr[8]['WIDTH'] = 30;
$lbr[9]['WIDTH'] = 30;

$pdf->tbSetHeaderType($lbr);

for ($b = 0; $b < $kol; $b++) {
	$jdl[$b] = $table_default_datax_type;
	$ket[$b] = $table_default_datax_type;
	$tbl1[$b] = $table_default_tblheader_type;
	$grs[$b] = $table_default_datax_type;
	$tbl2[$b] = $table_default_tbldata_type;
	$tbl3[$b] = $table_default_datax_type;
}

// ganti judul
$pdf->SetFont('Arial','B',12);
$pdf->Cell(280,5,"DAFTAR KARTU DATA " . strtoupper($jenis_pajak->ref_jenparet_ket),0,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(280,7,"TAHUN : " . $_GET['spt_periode'],0,1,'C');
// end ganti judul

// $jdl[0]['COLSPAN'] = 10;
// $jdl[0]['T_ALIGN'] = 'C';
// $jdl[0]['TEXT'] = "<h1>DAFTAR KARTU DATA " . strtoupper($jenis_pajak->ref_jenparet_ket) . "</h1>\n<h2>TTAHUN : " . $_GET['spt_periode'] . "</h2>";
// $pdf->tbDrawData($jdl);

// $jdl[0]['TEXT'] = "";
// $pdf->tbDrawData($jdl);


$tbl1[0]['TEXT'] = "<b>No.</b>";
$tbl1[1]['TEXT'] = "<b>S P T P D</b>";
$tbl1[3]['TEXT'] = "<b>Nama</b>";
$tbl1[4]['TEXT'] = "<b>A l a m a t</b>";
$tbl1[5]['TEXT'] = "<b>N P W P D</b>";
$tbl1[6]['TEXT'] = "<b>Masa Pajak</b>";
$tbl1[7]['TEXT'] = "<b>Tarif\n(%)</b>";
$tbl1[8]['TEXT'] = "<b>O m z e t  (Rp.)</b>";
$tbl1[9]['TEXT'] = "<b>P a j a k (Rp.)</b>";

$tbl1[1]['COLSPAN'] = 2;
$tbl1[0]['ROWSPAN'] = 2;
$tbl1[3]['ROWSPAN'] = 2;
$tbl1[4]['ROWSPAN'] = 2;
$tbl1[5]['ROWSPAN'] = 2;
$tbl1[6]['ROWSPAN'] = 2;
$tbl1[7]['ROWSPAN'] = 2;
$tbl1[8]['ROWSPAN'] = 2;
$tbl1[9]['ROWSPAN'] = 2;

$tbl1[0]['LN_SIZE'] = 6;
$tbl1[1]['LN_SIZE'] = 6;
$tbl1[2]['LN_SIZE'] = 6;
$tbl1[3]['LN_SIZE'] = 6;
$tbl1[4]['LN_SIZE'] = 6;
$tbl1[5]['LN_SIZE'] = 6;
$tbl1[6]['LN_SIZE'] = 6;
$tbl1[7]['LN_SIZE'] = 6;
$tbl1[8]['LN_SIZE'] = 6;
$tbl1[9]['LN_SIZE'] = 6;

$tbl1[0]['BRD_TYPE'] = 'LT';
$tbl1[1]['BRD_TYPE'] = 'LT';
$tbl1[3]['BRD_TYPE'] = 'LT';
$tbl1[4]['BRD_TYPE'] = 'LT';
$tbl1[5]['BRD_TYPE'] = 'LT';
$tbl1[6]['BRD_TYPE'] = 'LT';
$tbl1[7]['BRD_TYPE'] = 'LT';
$tbl1[8]['BRD_TYPE'] = 'LT';
$tbl1[9]['BRD_TYPE'] = 'LRT';
$pdf->tbDrawData($tbl1);

$tbl1[1]['TEXT'] = "<b>Tanggal</b>";
$tbl1[2]['TEXT'] = "<b>No. Urut</b>";
$tbl1[1]['COLSPAN'] = 1;
$tbl1[2]['BRD_TYPE'] = 'LRT';
$pdf->tbDrawData($tbl1);

$counter = 1;
$omset = 0;
$pajak = 0;
if (!empty($rows)) {
	foreach ($rows as $key => $val) {
		$tbl2[0]['TEXT'] = "" . $counter . ".";
		$tbl2[1]['TEXT'] = "" . format_tgl($val['spt_tgl_proses']);
		$tbl2[2]['TEXT'] = "" . $val['spt_nomor'];
		$tbl2[3]['TEXT'] = "" . $val['wp_wr_nama'];
		$tbl2[4]['TEXT'] = "" . preg_replace("\r|\n|", "", $val['wp_wr_almt']);
		$tbl2[5]['TEXT'] = "" . $val['npwprd'];
		$arr_periode = explode("-", $val['spt_periode_jual1']);
		$tbl2[6]['TEXT'] = getNamaBulan($arr_periode[1]) . " " . $arr_periode[0];
		$tbl2[7]['TEXT'] = "" . (!empty($val['spt_dt_persen_tarif'])) ? $val['spt_dt_persen_tarif'] : $val['korek_persen_tarif'];
		$tbl2[8]['TEXT'] = "" . number_format($val['spt_dt_jumlah'], 2, ',', '.');
		$tbl2[9]['TEXT'] = "" . number_format($val['spt_dt_pajak'], 2, ',', '.');
		$omset += $val['spt_dt_jumlah'];
		$pajak += $val['spt_dt_pajak'];

		$tbl2[0]['V_ALIGN'] = 'T';
		$tbl2[1]['V_ALIGN'] = 'T';
		$tbl2[2]['V_ALIGN'] = 'T';
		$tbl2[3]['V_ALIGN'] = 'T';
		$tbl2[4]['V_ALIGN'] = 'T';
		$tbl2[5]['V_ALIGN'] = 'T';
		$tbl2[6]['V_ALIGN'] = 'T';
		$tbl2[7]['V_ALIGN'] = 'T';
		$tbl2[8]['V_ALIGN'] = 'T';
		$tbl2[9]['V_ALIGN'] = 'T';

		$tbl2[0]['T_ALIGN'] = 'R';
		$tbl2[1]['T_ALIGN'] = 'C';
		$tbl2[2]['T_ALIGN'] = 'C';
		$tbl2[5]['T_ALIGN'] = 'C';
		$tbl2[6]['T_ALIGN'] = 'C';
		$tbl2[7]['T_ALIGN'] = 'C';
		$tbl2[8]['T_ALIGN'] = 'R';
		$tbl2[9]['T_ALIGN'] = 'R';

		$tbl2[0]['BRD_TYPE'] = 'LT';
		$tbl2[1]['BRD_TYPE'] = 'LT';
		$tbl2[2]['BRD_TYPE'] = 'LT';
		$tbl2[3]['BRD_TYPE'] = 'LT';
		$tbl2[4]['BRD_TYPE'] = 'LT';
		$tbl2[5]['BRD_TYPE'] = 'LT';
		$tbl2[6]['BRD_TYPE'] = 'LT';
		$tbl2[7]['BRD_TYPE'] = 'LT';
		$tbl2[8]['BRD_TYPE'] = 'LT';
		$tbl2[9]['BRD_TYPE'] = 'LRT';

		$tbl2[0]['T_SIZE'] = '8';
		$tbl2[1]['T_SIZE'] = '8';
		$tbl2[2]['T_SIZE'] = '8';
		$tbl2[3]['T_SIZE'] = '8';
		$tbl2[4]['T_SIZE'] = '8';
		$tbl2[5]['T_SIZE'] = '8';
		$tbl2[6]['T_SIZE'] = '8';
		$tbl2[7]['T_SIZE'] = '8';
		$tbl2[8]['T_SIZE'] = '8';
		$tbl2[9]['T_SIZE'] = '8';

		$tbl2[0]['LN_SIZE'] = $line_spacing;
		$tbl2[1]['LN_SIZE'] = $line_spacing;
		$tbl2[2]['LN_SIZE'] = $line_spacing;
		$tbl2[3]['LN_SIZE'] = $line_spacing;
		$tbl2[4]['LN_SIZE'] = $line_spacing;
		$tbl2[5]['LN_SIZE'] = $line_spacing;
		$tbl2[6]['LN_SIZE'] = $line_spacing;
		$tbl2[7]['LN_SIZE'] = $line_spacing;
		$tbl2[8]['LN_SIZE'] = $line_spacing;
		$tbl2[9]['LN_SIZE'] = $line_spacing;

		$pdf->tbDrawData($tbl2);

		$counter++;
	}
}

$tbl3[0]['TEXT'] = "J U M L A H";
$tbl3[8]['TEXT'] = number_format($omset, "2", ",", ".");
$tbl3[9]['TEXT'] = number_format($pajak, "2", ",", ".");
$tbl3[0]['T_SIZE'] = '8';
$tbl3[0]['T_TYPE'] = 'B';
$tbl3[8]['T_SIZE'] = '8';
$tbl3[9]['T_SIZE'] = '8';
$tbl3[0]['T_ALIGN'] = 'C';
$tbl3[8]['T_ALIGN'] = 'R';
$tbl3[9]['T_ALIGN'] = 'R';
$tbl3[0]['COLSPAN'] = 8;
$tbl3[0]['BRD_TYPE'] = 'LT';
$tbl3[8]['BRD_TYPE'] = 'LT';
$tbl3[9]['BRD_TYPE'] = 'LRT';
$pdf->tbDrawData($tbl3);

$grs[0]['TEXT'] = "";
$grs[0]['COLSPAN'] = 10;
$grs[0]['LN_SIZE'] = 6;
$grs[0]['BRD_TYPE'] = 'T';
$pdf->tbDrawData($grs);

$pdf->tbOuputData();

//Tanda Tangan
if ($_GET['tandatangan'] == "1") {
	// set page constants
	// height of resulting cell
	$cell_height = 4 + 1; // I have my cells at a height of five so set to six for a padding
	$height_of_cell = ceil(10 * $cell_height);
	$page_height = $pdf->h; // mm (landscape legal)
	$bottom_margin = 20; // mm

	// mm until end of page (less bottom margin of 20mm)
	$space_left = $page_height - $pdf->GetY(); // space left on page
	$space_left -= $bottom_margin; // less the bottom margin

	// test if height of cell is greater than space left
	if ($height_of_cell >= $space_left) {
		$pdf->Ln();

		$pdf->AddPage(); // page break.
	}


	//Tanda Tangan
	$kols = 3;
	$pdf->tbInitialize($kols, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);

	for ($c = 0; $c < $kols; $c++) $width[$c] = $table_default_datax_type;

	$width[0]['WIDTH'] = 94;
	$width[1]['WIDTH'] = 94;
	$width[2]['WIDTH'] = 89;

	$pdf->tbSetHeaderType($width);

	for ($d = 0; $d < $kols; $d++) {
		$ttd1[$d] = $table_default_ttd_type;
		$ket[$d] = $table_default_ttd_type;
	}

	$ttd1[0]['TEXT'] = "Mengetahui,";
	$ttd1[1]['TEXT'] = "Diperiksa Oleh,";
	$ttd1[2]['TEXT'] = "Bekasi, " . format_tgl($_GET['tgl_cetak'], false, true);
	$ttd1[2]['T_ALIGN'] = 'L';
	$pdf->tbDrawData($ttd1);

	if ($this->session->userdata('USER_SPT_CODE') == "10") {
		$ttd1[0]['TEXT'] = ($mengetahui->pejda_kode != '01') ? "a.n. " . $this->config->item('nama_jabatan_kepala_dinas') . "\n" . $mengetahui->ref_japeda_nama : "" . $mengetahui->ref_japeda_nama;
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
} else {
	//Tanda Tangan
	$kols = 3;
	$pdf->tbInitialize($kols, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);

	for ($c = 0; $c < $kols; $c++) $width[$c] = $table_default_datax_type;

	$width[0]['WIDTH'] = 94;
	$width[1]['WIDTH'] = 94;
	$width[2]['WIDTH'] = 89;

	$pdf->tbSetHeaderType($width);

	for ($d = 0; $d < $kols; $d++) {
		$ttd1[$d] = $table_default_ttd_type;
		$ket[$d] = $table_default_ttd_type;
	}

	$ttd1[0]['TEXT'] = "";
	$ttd1[1]['TEXT'] = "";
	$ttd1[2]['TEXT'] = "Bekasi, " . format_tgl($_GET['tgl_cetak'], false, true);
	$ttd1[2]['T_ALIGN'] = 'L';
	$pdf->tbDrawData($ttd1);

	$pdf->tbOuputData();
}

$pdf->Output();
