<?php

error_reporting(E_ERROR);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH . 'libraries/fpdf/table/class.fpdf_table.php';

// require APPPATH . 'libraries/fpdf/WriteHTML.php';
// require('application/libraries/fpdf/writehtml/WriteHTML.php');

//Class Extention for header and footer 
require_once APPPATH . 'libraries/fpdf/table/header_footer.inc';

//Table Defintion File
require_once APPPATH . 'libraries/fpdf/table/table_def.inc';

$pdf = new FPDF_TABLE('P', 'mm', 'A4'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
//$pdf->SetMargins(10, 10, 10);     // Margin Left, Top, Right 2 cm
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetStyle("sb", "arial", "B", 7, "0,0,0");
$pdf->SetStyle("b", "arial", "B", 12, "0,0,0");
$pdf->SetStyle("h1", "arial", "B", 14, "0,0,0");
$pdf->SetStyle("nu", "arial", "U", 8, "0,0,0");
$columns = 5; // bisa disesuaikan
// Lebar = 190

$pdf->tbInitialize($columns, true, true);
$pdf->tbSetTableType($table_default_kartu_type);

if (!empty($wp)) {
	for ($i = 0; $i < $columns; $i++)
		$header_type[$i] = $table_default_headerx_type;


	for ($i = 0; $i < $columns; $i++) {
		$spacer1[$i] = $table_default_kartu_type;
		$header_type1[$i] = $table_default_kartu_type;
		$spacer2[$i] = $table_default_kartu_type;
	}

	$spacer1[0]['WIDTH'] = 15;
	$spacer1[1]['WIDTH'] = 160;
	$spacer1[2]['WIDTH'] = 15;

	$spacer1[0]['TEXT'] = "";
	$spacer1[0]['COLSPAN'] = 3;
	$spacer1[0]['BRD_TYPE'] = 'LRT';
	$spacer1[0]['T_SIZE'] = 2;
	$spacer1[0]['LN_SIZE'] = 2;

	//Baris ke-1
	$header_type1[0]['TEXT'] = "";
	$header_type1[0]['BRD_TYPE'] = 'L';

	// test header
	// $pdf->SetFont('Arial', 'B', 14);
	// $pdf->Cell(190, 5, 'KARTU DATA', 0, 1, 'C');

	// $pdf->SetFont('Arial', 'B', 12);
	// $pdf->Cell(190, 7, 'PAJAK HOTEL', 0, 1, 'C');

	// $pdf->SetFont('Arial', '', 8);
	// $pdf->Cell(190, 7, "Tahun Pajak : " . $this->input->get('spt_periode'), 0, 1, 'C');

	// $pdf->SetFont('Arial', '', 8);
	// $pdf->Cell(190, 5, "N.P.W.P.D", 0, 1, 'C');

	// $pdf->SetFont('Arial', '', 8);
	// $pdf->Cell(190, 5, "" . $wp['npwprd'], 0, 1, 'C');

	// end test

	$header_type1[1]['TEXT'] = "<h1>KARTU DATA</h1>\n<b>PPAJAK HOTEL</b>\n<p>TTahun Pajak : " . $this->input->get('spt_periode')."</p>";
	$header_type1[1]['TEXT'] .= "\n<p>NN.P.W.P.D\n " . $wp['npwprd'] . "</p>";
	$header_type1[1]['T_ALIGN'] = 'C';
	$header_type1[1]['T_TYPE'] = '';
	$header_type1[1]['T_SIZE'] = 8;

	$header_type1[3]['LN_SIZE'] = 2;
	$header_type1[3]['BRD_TYPE'] = 'R';

	$spacer2[0]['TEXT'] = "";
	$spacer2[0]['COLSPAN'] = 3;
	$spacer2[0]['BRD_TYPE'] = 'LR';
	$spacer2[0]['T_SIZE'] = 2;
	$spacer2[0]['LN_SIZE'] = 2;

	$aHeaderArray = array(
		$spacer1,
		$header_type1,
		$spacer2
	);

	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);

	//Draw the Header
	$pdf->tbDrawHeader();
	$pdf->tbOuputData();
	// End of Header

	// Baris Identitas
	$coldata = 4;
	$pdf->tbInitialize($coldata, true, true);
	$pdf->tbSetTableType($table_default_kartu_type);

	for ($i = 0; $i < $coldata; $i++) $header_type[$i] = $table_default_header_type;

	$header_type[0]['WIDTH'] = 10;
	$header_type[1]['WIDTH'] = 35;
	$header_type[2]['WIDTH'] = 3;
	$header_type[3]['WIDTH'] = 142;

	$pdf->tbSetHeaderType($header_type);

	$data_type = array(); //reset the array
	for ($i = 0; $i < 4; $i++) $data_type[$i] = $table_default_kartu_type;

	$pdf->tbSetDataType($data_type);
	for ($j = 0; $j < $coldata; $j++) {
		$top[$j] = $table_default_kartu_type;
		$data1[$j] = $table_default_kartu_type;
		$data2[$j] = $table_default_kartu_type;
		$data3[$j] = $table_default_kartu_type;
		$data4[$j] = $table_default_kartu_type;
		$bot[$j] = $table_default_kartu_type;
	}

	//Padding Atas
	$top[0]['TEXT'] = "";
	$top[0]['COLSPAN'] = 4;
	$top[0]['T_SIZE'] = 2;
	$top[0]['LN_SIZE'] = 4;
	$top[0]['BRD_TYPE'] = 'LRT';
	$pdf->tbDrawData($top);

	$data = array();
	$data[0]['T_ALIGN'] = 'R';
	$data[0]['BRD_TYPE'] = 'L';
	$data[0]['TEXT'] = "1.";
	$data[1]['TEXT'] = "Bentuk Usaha";
	$data[2]['TEXT'] = ":";
	$data[3]['BRD_TYPE'] = 'R';
	if ($wp['wp_wr_gol'] == "2")
		$data[3]['TEXT'] = "[  ] Orang Pribadi          [ X ] Badan";
	else if ($wp['wp_wr_gol'] == "1")
		$data[3]['TEXT'] = "[ X ] Orang Pribadi         [  ] Badan";
	$pdf->tbDrawData($data);

	$data1 = array();
	$data1[0]['T_ALIGN'] = 'R';
	$data1[0]['BRD_TYPE'] = 'L';
	$data1[0]['TEXT'] = "2.";
	$data1[1]['TEXT'] = "Nama / Merek Usaha";
	$data1[2]['TEXT'] = ":";
	$data1[3]['BRD_TYPE'] = 'R';
	$data1[3]['TEXT'] = "" . $wp['wp_wr_nama'];
	$pdf->tbDrawData($data1);

	$data2 = array();
	$data2[0]['T_ALIGN'] = 'R';
	$data2[0]['BRD_TYPE'] = 'L';
	$data2[0]['TEXT'] = "3.";
	$data2[1]['TEXT'] = "Alamat Usaha";
	$data2[2]['TEXT'] = ":";
	$data2[3]['TEXT'] = "" .  $wp['wp_wr_almt'];
	$data2[3]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($data2);

	$data3 = array();
	$data3[0]['T_ALIGN'] = 'R';
	$data3[0]['BRD_TYPE'] = 'L';
	$data3[0]['TEXT'] = "4.";
	$data3[1]['TEXT'] = "Nama Pemilik";
	$data3[2]['TEXT'] = ":";
	$data3[3]['TEXT'] = "" . $wp['wp_wr_nama_milik'];
	$data3[3]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($data3);

	$data4 = array();
	$data4[0]['T_ALIGN'] = 'R';
	$data4[0]['BRD_TYPE'] = 'L';
	$data4[0]['TEXT'] = "5.";
	$data4[1]['TEXT'] = "Alamat Tempat Tinggal";
	$data4[2]['TEXT'] = ":";
	$data4[3]['TEXT'] = "" .  $wp['wp_wr_almt'];
	$data4[3]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($data4);

	//Padding Bawah
	$bot = array();
	$bot[0]['TEXT'] = "";
	$bot[0]['COLSPAN'] = 4;
	$bot[0]['T_SIZE'] = 2;
	$bot[0]['LN_SIZE'] = 4;
	$bot[0]['BRD_TYPE'] = 'LR';
	$pdf->tbDrawData($bot);

	$pdf->tbOuputData();
	// End of Baris Identitas

	// Baris Detail
	$kolom = 7;
	$pdf->tbInitialize($kolom, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);

	for ($i = 0; $i < $kolom; $i++) $setcol[$i] = $table_default_kartu_type;

	$setcol[0]['WIDTH'] = 7;
	$setcol[1]['WIDTH'] = 8;
	$setcol[2]['WIDTH'] = 10;
	$setcol[3]['WIDTH'] = 40;
	$setcol[4]['WIDTH'] = 40;
	$setcol[5]['WIDTH'] = 40;
	$setcol[6]['WIDTH'] = 45;

	$pdf->tbSetHeaderType($setcol);

	$tipedata = array();
	for ($j = 0; $j < $kolom; $j++) $tipedata[$j] = $table_default_kartu_type;

	$pdf->tbSetDataType($tipedata);

	for ($k = 0; $k < $kolom; $k++) {
		$padtop[$k] = $table_default_kartu_type;
		$datax1[$k] = $table_default_kartu_type;
		$datax2[$k] = $table_default_kartu_type;
		$datax3[$k] = $table_default_kartu_type;
		$datax4[$k] = $table_default_kartu_type;
	}

	//Padding Atas
	$padtop[0]['TEXT'] = "";
	$padtop[0]['COLSPAN'] = 7;
	$padtop[0]['T_SIZE'] = 2;
	$padtop[0]['LN_SIZE'] = 2;
	$padtop[0]['BRD_TYPE'] = 'LRT';
	$pdf->tbDrawData($padtop);

	$datax1 = array();
	$datax1[0]['BRD_TYPE'] = 'L';
	$datax1[0]['TEXT'] = "A.";
	$datax1[0]['T_ALIGN'] = 'R';
	$datax1[1]['COLSPAN'] = 6;
	$datax1[1]['BRD_TYPE'] = 'R';
	$datax1[1]['TEXT'] = "Objek Hotel";
	$pdf->tbDrawData($datax1);

	$datax2 = array();
	$datax2[0]['BRD_TYPE'] = 'L';
	$datax2[0]['TEXT'] = "";
	$datax2[0]['T_ALIGN'] = 'R';
	$datax2[1]['TEXT'] = "A.1.";
	$datax2[2]['COLSPAN'] = 2;
	$datax2[2]['TEXT'] = "Golongan Hotel  :      [   ][   ]";
	$datax2[4]['COLSPAN'] = 2;
	$datax2[4]['TEXT'] = "01  Bintang lima                  06  Melati tiga";
	$datax2[6]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($datax2);

	$datax2 = array();
	$datax2[0]['BRD_TYPE'] = 'L';
	$datax2[0]['TEXT'] = "";
	$datax2[0]['T_ALIGN'] = 'R';
	$datax2[1]['TEXT'] = "";
	$datax2[2]['COLSPAN'] = 2;
	$datax2[2]['TEXT'] = "";
	$datax2[4]['COLSPAN'] = 2;
	$datax2[4]['TEXT'] = "02  Bintang empat               07  Melati dua";
	$datax2[6]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($datax2);

	$datax2 = array();
	$datax2[0]['BRD_TYPE'] = 'L';
	$datax2[0]['TEXT'] = "";
	$datax2[0]['T_ALIGN'] = 'R';
	$datax2[1]['TEXT'] = "";
	$datax2[2]['COLSPAN'] = 2;
	$datax2[2]['TEXT'] = "";
	$datax2[4]['COLSPAN'] = 2;
	$datax2[4]['TEXT'] = "03  Bintang tiga                   08  Melati satu";
	$datax2[6]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($datax2);

	$datax2 = array();
	$datax2[0]['BRD_TYPE'] = 'L';
	$datax2[0]['TEXT'] = "";
	$datax2[0]['T_ALIGN'] = 'R';
	$datax2[1]['TEXT'] = "";
	$datax2[2]['COLSPAN'] = 2;
	$datax2[2]['TEXT'] = "";
	$datax2[4]['COLSPAN'] = 2;
	$datax2[4]['TEXT'] = "04  Bintang dua                   09  Ekonomi";
	$datax2[6]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($datax2);

	$datax2 = array();
	$datax2[0]['BRD_TYPE'] = 'L';
	$datax2[0]['TEXT'] = "";
	$datax2[0]['T_ALIGN'] = 'R';
	$datax2[1]['TEXT'] = "";
	$datax2[2]['COLSPAN'] = 2;
	$datax2[2]['TEXT'] = "";
	$datax2[4]['COLSPAN'] = 2;
	$datax2[4]['TEXT'] = "05  Bintang satu                  10  Lainnya : .........";
	$datax2[6]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($datax2);

	$datax3 = array();
	$datax3[0]['BRD_TYPE'] = 'L';
	$datax3[0]['TEXT'] = "";
	$datax3[1]['TEXT'] = "A.2.";
	$datax3[2]['TEXT'] = "Tarif dan jumlah kamar hotel";
	$datax3[2]['COLSPAN'] = 4;
	$datax3[6]['TEXT'] = "";
	$datax3[6]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($datax3);

	$data_tarif = array();
	$data_tarif[0]['BRD_TYPE'] = 'L';
	$data_tarif[0]['TEXT'] = "";
	$data_tarif[1]['TEXT'] = "";

	$data_tarif[2]['TEXT'] = "No.";
	$data_tarif[2]['T_ALIGN'] = 'C';
	$data_tarif[2]['BRD_TYPE'] = 'LT';

	$data_tarif[3]['TEXT'] = "Golongan Kamar";
	$data_tarif[3]['T_ALIGN'] = 'C';
	$data_tarif[3]['BRD_TYPE'] = 'LT';

	$data_tarif[4]['TEXT'] = "Tarif (Rp)";
	$data_tarif[4]['T_ALIGN'] = 'C';
	$data_tarif[4]['BRD_TYPE'] = 'LT';

	$data_tarif[5]['TEXT'] = "Jumlah Kamar";
	$data_tarif[5]['T_ALIGN'] = 'C';
	$data_tarif[5]['BRD_TYPE'] = 'LT';

	$data_tarif[6]['TEXT'] = "";
	$data_tarif[6]['BRD_TYPE'] = 'LR';

	$pdf->tbDrawData($data_tarif);
	for ($i = 1; $i <= 3; $i++) {
		$dtx = array();
		$dtx[0]['TEXT'] = "";
		$dtx[0]['BRD_TYPE'] = 'L';
		$dtx[1]['TEXT'] = "";
		$dtx[2]['TEXT'] = $i . ".";
		$dtx[2]['T_ALIGN'] = 'R';
		$dtx[2]['BRD_TYPE'] = 'LT';
		$dtx[3]['TEXT'] = "";
		$dtx[3]['BRD_TYPE'] = 'LT';
		$dtx[4]['TEXT'] = "";
		$dtx[4]['T_ALIGN'] = 'R';
		$dtx[4]['BRD_TYPE'] = 'LT';
		$dtx[5]['TEXT'] = "";
		$dtx[5]['T_ALIGN'] = 'C';
		$dtx[5]['BRD_TYPE'] = 'LT';
		$dtx[6]['TEXT'] = "";
		$dtx[6]['BRD_TYPE'] = 'LR';

		$pdf->tbDrawData($dtx);
	}

	$datax4[0]['TEXT'] = "";
	$datax4[1]['TEXT'] = "";
	$datax4[2]['TEXT'] = "";
	$datax4[3]['TEXT'] = "";
	$datax4[4]['TEXT'] = "";
	$datax4[5]['TEXT'] = "";
	$datax4[6]['TEXT'] = "";

	$datax4[0]['BRD_TYPE'] = 'L';
	$datax4[2]['BRD_TYPE'] = 'T';
	$datax4[3]['BRD_TYPE'] = 'T';
	$datax4[4]['BRD_TYPE'] = 'T';
	$datax4[5]['BRD_TYPE'] = 'T';
	$datax4[6]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($datax4);

	$data = array();
	$data[0]['BRD_TYPE'] = 'L';
	$data[0]['TEXT'] = "B.";
	$data[0]['T_ALIGN'] = 'R';
	$data[1]['COLSPAN'] = 6;
	$data[1]['BRD_TYPE'] = 'R';
	$data[1]['TEXT'] = "Gedung Pertemuan";
	$pdf->tbDrawData($data);

	$data_tarif = array();
	$data_tarif[0]['BRD_TYPE'] = 'L';
	$data_tarif[0]['TEXT'] = "";
	$data_tarif[1]['TEXT'] = "";

	$data_tarif[2]['TEXT'] = "No.";
	$data_tarif[2]['T_ALIGN'] = 'C';
	$data_tarif[2]['BRD_TYPE'] = 'LT';

	$data_tarif[3]['TEXT'] = "Golongan Gedung";
	$data_tarif[3]['T_ALIGN'] = 'C';
	$data_tarif[3]['BRD_TYPE'] = 'LT';

	$data_tarif[4]['TEXT'] = "Tarif (Rp)";
	$data_tarif[4]['T_ALIGN'] = 'C';
	$data_tarif[4]['BRD_TYPE'] = 'LT';

	$data_tarif[5]['TEXT'] = "Jumlah Kursi";
	$data_tarif[5]['T_ALIGN'] = 'C';
	$data_tarif[5]['BRD_TYPE'] = 'LT';

	$data_tarif[6]['TEXT'] = "";
	$data_tarif[6]['BRD_TYPE'] = 'LR';
	$pdf->tbDrawData($data_tarif);

	for ($i = 1; $i <= 3; $i++) {
		$dtx = array();
		$dtx[0]['TEXT'] = "";
		$dtx[0]['BRD_TYPE'] = 'L';
		$dtx[1]['TEXT'] = "";
		$dtx[2]['TEXT'] = $i . ".";
		$dtx[2]['T_ALIGN'] = 'R';
		$dtx[2]['BRD_TYPE'] = 'LT';
		$dtx[3]['TEXT'] = "";
		$dtx[3]['BRD_TYPE'] = 'LT';
		$dtx[4]['TEXT'] = "";
		$dtx[4]['T_ALIGN'] = 'R';
		$dtx[4]['BRD_TYPE'] = 'LT';
		$dtx[5]['TEXT'] = "";
		$dtx[5]['T_ALIGN'] = 'C';
		$dtx[5]['BRD_TYPE'] = 'LT';
		$dtx[6]['TEXT'] = "";
		$dtx[6]['BRD_TYPE'] = 'LR';

		$pdf->tbDrawData($dtx);
	}

	$data = array();
	$data[0]['TEXT'] = "";
	$data[1]['TEXT'] = "";
	$data[2]['TEXT'] = "";
	$data[3]['TEXT'] = "";
	$data[4]['TEXT'] = "";
	$data[5]['TEXT'] = "";
	$data[6]['TEXT'] = "";

	$data[0]['BRD_TYPE'] = 'L';
	$data[2]['BRD_TYPE'] = 'T';
	$data[3]['BRD_TYPE'] = 'T';
	$data[4]['BRD_TYPE'] = 'T';
	$data[5]['BRD_TYPE'] = 'T';
	$data[6]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($data);

	for ($m = 0; $m < $kolom; $m++) {
		$bar1[$m] = $table_default_kartu_type;
		$bar2[$m] = $table_default_kartu_type;
		$bar3[$m] = $table_default_kartu_type;
		$bar4[$m] = $table_default_kartu_type;
	}

	$bar1[0]['TEXT'] = "C.";
	$bar1[0]['T_ALIGN'] = 'R';
	$bar1[1]['TEXT'] = "Diisi untuk Objek Hotel dan Gedung Pertemuan";
	$bar1[1]['COLSPAN'] = 6;
	$bar1[0]['BRD_TYPE'] = 'L';
	$bar1[1]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($bar1);

	$bar2 = array();
	$bar2[0]['TEXT'] = "";
	$bar2[0]['BRD_TYPE'] = 'L';
	$bar2[1]['TEXT'] = "C.1. Menggunakan Kas Register";
	$bar2[1]['COLSPAN'] = 3;
	$bar2[4]['TEXT'] = "[   ]  1. Ya";
	$bar2[4]['COLSPAN'] = 3;
	$bar2[4]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($bar2);

	$bar2 = array();
	$bar2[0]['TEXT'] = "";
	$bar2[0]['BRD_TYPE'] = 'L';
	$bar2[1]['TEXT'] = "";
	$bar2[1]['COLSPAN'] = 3;
	$bar2[4]['TEXT'] = "       2. Tidak\n\n";
	$bar2[4]['COLSPAN'] = 3;
	$bar2[4]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($bar2);

	$bar4[0]['TEXT'] = "";
	$bar4[0]['BRD_TYPE'] = 'L';
	$bar4[1]['TEXT'] = "C.2. Jumlah pembayaran dan setoran yang dilakukan";
	$bar4[1]['COLSPAN'] = 6;
	$bar4[1]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($bar4);
	$pdf->tbOuputData();

	//Rincian Omzet dan Setoran
	$kol = 7;
	$pdf->tbInitialize($kol, true, true);
	$pdf->tbSetTableType($table_default_kartu_type);

	for ($a = 0; $a < $kol; $a++)
		$klm[$a] = $table_default_kartu_type;

	$klm[0]['WIDTH'] = 5;
	$klm[1]['WIDTH'] = 10;
	$klm[2]['WIDTH'] = 35;
	$klm[3]['WIDTH'] = 55;
	$klm[4]['WIDTH'] = 40;
	$klm[5]['WIDTH'] = 40;
	$klm[6]['WIDTH'] = 5;

	$klm[0]['TEXT'] = "";
	$klm[0]['BRD_TYPE'] = 'L';
	$klm[1]['TEXT'] = "No.";
	$klm[1]['T_ALIGN'] = 'C';
	$klm[1]['BRD_TYPE'] = 'LT';
	$klm[2]['TEXT'] = "Tanggal";
	$klm[2]['T_ALIGN'] = 'C';
	$klm[2]['BRD_TYPE'] = 'LT';
	$klm[3]['TEXT'] = "Masa Pajak";
	$klm[3]['T_ALIGN'] = 'C';
	$klm[3]['BRD_TYPE'] = 'LT';
	$klm[4]['TEXT'] = "Jumlah Pajak (Rp)";
	$klm[4]['T_ALIGN'] = 'C';
	$klm[4]['BRD_TYPE'] = 'LT';
	$klm[5]['TEXT'] = "Setoran (Rp)";
	$klm[5]['T_ALIGN'] = 'C';
	$klm[5]['BRD_TYPE'] = 'LT';
	$klm[6]['TEXT'] = "";
	$klm[6]['BRD_TYPE'] = 'LR';

	$pdf->tbSetHeaderType($klm);
	$pdf->tbDrawHeader();

	//Table Data Settings
	$data_type = array(); //reset the array
	for ($i = 0; $i < $kol; $i++)
		$data_type[$i] = $table_default_kartu_type;

	$pdf->tbSetDataType($data_type);

	$counter = 1;
	$jumlah_pajak = 0;
	$jumlah_setoran = 0;

	if (count($arr_spt) > 0) {
		foreach ($arr_spt as $row) {
			$dat[0]['TEXT'] = "";
			$dat[0]['BRD_TYPE'] = 'L';
			$dat[1]['TEXT'] = "" . $counter . ".";
			$dat[1]['T_ALIGN'] = 'R';
			$dat[1]['BRD_TYPE'] = 'LT';
			$dat[2]['TEXT'] = "" . format_tgl($row['spt_tgl_proses']);
			$dat[2]['T_ALIGN'] = 'C';
			$dat[2]['BRD_TYPE'] = 'LT';
			$dat[3]['TEXT'] = format_tgl($row['spt_periode_jual1']) . " s.d " . format_tgl($row['spt_periode_jual2']);
			$dat[3]['BRD_TYPE'] = 'LT';
			$dat[3]['T_ALIGN'] = 'C';
			$dat[4]['TEXT'] = "" . format_currency($row['spt_pajak']);
			$dat[4]['T_ALIGN'] = 'R';
			$dat[4]['BRD_TYPE'] = 'LT';
			$dat[5]['TEXT'] = "" . format_currency($row['setorpajret_jlh_bayar']);
			$dat[5]['T_ALIGN'] = 'R';
			$dat[5]['BRD_TYPE'] = 'LT';
			$dat[6]['TEXT'] = "";
			$dat[6]['BRD_TYPE'] = 'LR';

			$pdf->tbDrawData($dat);
			$jumlah_pajak += $row['spt_pajak'];
			$jumlah_setoran += $row['setorpajret_jlh_bayar'];

			$counter++;
		}
	}

	for ($i = count($arr_spt); $i < 12; $i++) {
		$dat[0]['TEXT'] = "";
		$dat[0]['BRD_TYPE'] = 'L';
		$dat[1]['TEXT'] = "" . $counter . ".";
		$dat[1]['T_ALIGN'] = 'R';
		$dat[1]['BRD_TYPE'] = 'LT';
		$dat[2]['TEXT'] = "";
		$dat[2]['T_ALIGN'] = 'C';
		$dat[2]['BRD_TYPE'] = 'LT';
		$dat[3]['TEXT'] = "";
		$dat[3]['BRD_TYPE'] = 'LT';
		$dat[3]['T_ALIGN'] = 'C';
		$dat[4]['TEXT'] = "";
		$dat[4]['T_ALIGN'] = 'R';
		$dat[4]['BRD_TYPE'] = 'LT';
		$dat[5]['TEXT'] = "";
		$dat[5]['T_ALIGN'] = 'R';
		$dat[5]['BRD_TYPE'] = 'LT';
		$dat[6]['TEXT'] = "";
		$dat[6]['BRD_TYPE'] = 'LR';

		$pdf->tbDrawData($dat);
		$counter++;
	}

	$dat[0]['TEXT'] = "";
	$dat[0]['BRD_TYPE'] = 'L';
	$dat[1]['TEXT'] = "J U M L A H";
	$dat[1]['T_ALIGN'] = 'C';
	$dat[1]['BRD_TYPE'] = 'LT';
	$dat[1]['COLSPAN'] = 3;
	$dat[4]['TEXT'] = format_currency($jumlah_pajak);
	$dat[4]['T_ALIGN'] = 'R';
	$dat[4]['BRD_TYPE'] = 'LT';
	$dat[5]['TEXT'] = format_currency($jumlah_setoran);
	$dat[5]['T_ALIGN'] = 'R';
	$dat[5]['BRD_TYPE'] = 'LT';
	$dat[6]['TEXT'] = "";
	$dat[6]['BRD_TYPE'] = 'LR';

	$pdf->tbDrawData($dat);

	for ($c = 0; $c < $kol; $c++)
		$ntbl[$c] = $table_default_kartu_type;

	$ntbl[0]['TEXT'] = "";
	$ntbl[1]['TEXT'] = "";
	$ntbl[2]['TEXT'] = "";
	$ntbl[3]['TEXT'] = "";
	$ntbl[4]['TEXT'] = "";
	$ntbl[5]['TEXT'] = "";
	$ntbl[6]['TEXT'] = "";
	$ntbl[0]['BRD_TYPE'] = 'L';
	$ntbl[1]['BRD_TYPE'] = 'T';
	$ntbl[2]['BRD_TYPE'] = 'T';
	$ntbl[3]['BRD_TYPE'] = 'T';
	$ntbl[4]['BRD_TYPE'] = 'T';
	$ntbl[5]['BRD_TYPE'] = 'T';
	$ntbl[6]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($ntbl);

	//output the table data to the pdf
	$pdf->tbOuputData();
	//End of Rincian Omzet dan Setoran

	//Baris Tanda Tangan
	$jkol = 2;
	$pdf->tbInitialize($jkol, true, true);
	$pdf->tbSetTableType($table_default_kartu_type);

	for ($d = 0; $d < $jkol; $d++) $kols[$d] = $table_default_kartu_type;

	$kols[0]['WIDTH'] = 95;
	$kols[1]['WIDTH'] = 95;

	$pdf->tbSetHeaderType($kols);
	$pdf->tbDrawHeader();

	for ($e = 0; $e < $jkol; $e++) {
		$jarak1[$e] = $table_default_kartu_type;
		$ket1[$e] = $table_default_kartu_type;
		$ket2[$e] = $table_default_kartu_type;
		$ttd[$e] = $table_default_kartu_type;
		$nama[$e] = $table_default_kartu_type;
		$jbtn[$e] = $table_default_kartu_type;
		$nip[$e] = $table_default_kartu_type;
		$jarak2[$e] = $table_default_kartu_type;
	}

	$jarak1[0]['TEXT'] = "";
	$jarak1[0]['COLSPAN'] = 3;
	$jarak1[0]['T_SIZE'] = 3;
	$jarak1[0]['LN_SIZE'] = 3;
	$pdf->tbDrawData($jarak1);

	$ket1[0]['T_ALIGN'] = 'C';
	$ket1[0]['TEXT'] = "Mengetahui,";
	$ket1[1]['T_ALIGN'] = 'C';
	$ket1[1]['TEXT'] = "Dibuat Oleh,";
	$pdf->tbDrawData($ket1);

	$ket2[0]['T_ALIGN'] = 'C';
	$ket2[0]['TEXT'] = "" . $mengetahui['ref_japeda_nama'];
	$ket2[1]['T_ALIGN'] = 'C';
	$ket2[1]['TEXT'] = "" . $dibuat['ref_japeda_nama'];
	$pdf->tbDrawData($ket2);

	$ttd[0]['TEXT'] = "";
	$ttd[0]['COLSPAN'] = 2;
	$pdf->tbDrawData($ttd);
	$pdf->tbDrawData($ttd);
	$pdf->tbDrawData($ttd);

	$nama[0]['T_ALIGN'] = 'C';
	$nama[0]['TEXT'] = "<nu>  " . $mengetahui['pejda_nama'] . "  </nu>";
	$nama[1]['T_ALIGN'] = 'C';
	$nama[1]['TEXT'] = "<nu>  " . $dibuat['pejda_nama'] . "  </nu>";
	$pdf->tbDrawData($nama);
		
	$jbtn[0]['T_ALIGN'] = 'C';
	$jbtn[0]['TEXT'] = "" . $mengetahui['ref_pangpej_ket'];
	$jbtn[1]['T_ALIGN'] = 'C';
	$jbtn[1]['TEXT'] = "" . $dibuat['ref_pangpej_ket'];
	$pdf->tbDrawData($jbtn);
		
	$nip[0]['T_ALIGN'] = 'C';
	$nip[0]['TEXT'] = "NIP.  " . $mengetahui['pejda_nip'];
	$nip[1]['T_ALIGN'] = 'C';
	$nip[1]['TEXT'] = "NIP.  " . $dibuat['pejda_nip'];
	$pdf->tbDrawData($nip);
	
	$jarak2[0]['TEXT'] = "";
	$jarak2[0]['COLSPAN'] = 2;
	$jarak2[0]['T_SIZE'] = 2;
	$jarak2[0]['LN_SIZE'] = 2;
	$pdf->tbDrawData($jarak2);
		
	$pdf->tbOuputData();
	$pdf->tbDrawBorder();
		
	//write to pdf
	$pdf->Output();
} else {
	echo "Maaf data tidak ditemukan.";
}
